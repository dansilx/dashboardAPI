<?php
    include('../../includes/conexaoNova.php');

    function BancoSaldo() 
    {
        header('Content-Type: Application/json; charset=utf-8' );

        $retorno = [
            'dados' => [],
            'mensagem' => [],
            'erro' => false
        ];

        $dados = [];

        try{

            $sqlBanco = "SELECT FIN_FN_RET_DESCR_CC(SB.N_COD_C_CORR_EMPRESA, 2) AS CONTA,
                                REPLACE(ROUND(NVL(CB.V_VLR_LIMITE, 0), 2), ',', '.') AS LIMITE,
                                REPLACE(ROUND(NVL(CB.V_VLR_TAXA, 0), 2), ',', '.')   AS TAXA,
                                REPLACE(ROUND(NVL(SB.SDCONTA2, 0), 2), ',', '.')     AS SALDO_ANTERIOR,
                                SB.N_COD_C_CORR_EMPRESA                              AS CONTA_CORRENTE_EMPRESA,
                                REPLACE(ROUND(NVL((
                                    SELECT 
                                            NVL(SB2.SDCONTA2,0)
                                    FROM FIN_SALDOS_CB SB2
                                    INNER JOIN FIN_CONTA_BANCARIA CB2
                                    ON (CB2.N_COD_CONTA_BANCARIA = SB2.N_COD_C_CORR_EMPRESA)
                                    WHERE SB2.N_MES = SB.N_MES
                                    AND SB2.N_ANO = SB.N_ANO
                                    AND CB2.F_TIPO_CONTA_NABI = 'A'
                                    AND CB2.N_COD_BANCO = CB.N_COD_BANCO
                                    AND CB2.N_COD_AGENCIA = CB.N_COD_AGENCIA
                                    AND CB2.C_NRO_CONTA_BANCARIA = CB.C_NRO_CONTA_BANCARIA
                                ), 0), 2), ',', '.') AS SALDO_APLICACAO
                            FROM FIN_SALDOS_CB SB
                            INNER JOIN FIN_CONTA_BANCARIA CB
                                ON (CB.N_COD_CONTA_BANCARIA = SB.N_COD_C_CORR_EMPRESA)
                            WHERE LPAD(SB.N_MES, 2, '0') || '/' || SB.N_ANO = TO_CHAR(SYSDATE - 1, 'MM/YYYY')
                            AND CB.F_TIPO_CONTA_NABI = 'N'
                            ORDER BY CONTA";

            $con = bd(); 
            $stmtBanco = oci_parse($con, $sqlBanco);
            if(!oci_execute($stmtBanco)) {
                throw new Exception("Erro ao executar query dos bancos.");
            }

            while($rowBanco = oci_fetch_assoc($stmtBanco)){

                $arrLancamentos = [];

                $sqlLancamentos = "SELECT CP.C_OBSERVACAO AS DECRICAO, 
                                        REPLACE(ROUND(NVL(CP.V_VLR_VALOR,0),2),',','.') AS VALOR
                                    FROM FIN_PAGAMENTO PG
                                    INNER JOIN FIN_PGTO_X_DUPLICATAS PGD
                                        ON (PG.N_COD_PAGAMENTO = PGD.N_COD_PAGAMENTO)
                                    INNER JOIN FIN_CONTA_PAGAR CP
                                        ON (CP.N_COD_CONTA_PAGAR = PGD.N_COD_CONTA_PAGAR)
                                    WHERE PG.D_PAGAMENTO = TRUNC(SYSDATE-1)
                                        AND PG.N_COD_C_CORR_EMPRESA = ".$rowBanco["CONTA_CORRENTE_EMPRESA"];

                $stmtLancamentos = oci_parse($con, $sqlLancamentos);
                if(!oci_execute($stmtLancamentos)) {
                    throw new Exception("Erro ao executar query dos lançamentos");
                }
                while($rowLancamentos = oci_fetch_assoc($stmtLancamentos)){

                    array_push($arrLancamentos, [
                        "descricao" => $rowLancamentos['DECRICAO'],
                        "valor" => (float) $rowLancamentos['VALOR']
                    ]);
                }
                
                $totalLancamentos = (float) array_sum(array_column($arrLancamentos, 'valor'));
                $totalDisponivel = ( (float) $rowBanco['SALDO_ANTERIOR'] ) + $totalLancamentos + ( (float) $rowBanco['SALDO_APLICACAO'] );
                $saldoEmCC = ( (float) $rowBanco['SALDO_ANTERIOR'] ) + $totalLancamentos;

                array_push($dados, [
                    "conta" => $rowBanco['CONTA'],
                    "limite" => (float) $rowBanco['LIMITE'],
                    "taxa" => (float) $rowBanco['TAXA'],
                    "saldoAnterior" => (float) $rowBanco['SALDO_ANTERIOR'],
                    "lancamentos" => $arrLancamentos,
                    "totalLancamentos" =>  $totalLancamentos,
                    "saldoEmCC" => round($saldoEmCC, 2),
                    "saldoAplicacoes" => (float) $rowBanco['SALDO_APLICACAO'],
                    "totalDisponivel" => round($totalDisponivel, 2)
                ]);
            }

            $retorno['dados'] = $dados;

        } catch(Exception $e) {
            $retorno['erro'] = true;
            $retorno['mensagem'][] = $e->getMessage();
        }

        if($con){
            oci_close($con);
        }
        

        return json_encode($retorno);
    }
    
    
    
    
    
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":

            if (isset($_GET["funcao"])) {
                switch ($_GET["funcao"]) {

                    case "BancoSaldo":

                        echo BancoSaldo();

                    break;
                }
            }

            break;
            
    }