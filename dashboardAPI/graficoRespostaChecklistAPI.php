<?php

    include_once("../../includes/conexaoNova.php");

    function retornaDadosChecklist($dataInicio, $dataTermino, $agruparPor){

        header('Content-Type: Application/json; charset=utf-8' );

        $con = bd();

        $retorno = [
            'dados' => [],
            'mensagem' => [],
            'erro' => false
        ];

        $dadosChecklist = [];

        try{

            switch($agruparPor)
            {
                case 'ativo': // agrupado por ativo

                    $selectNome = "
                        (SELECT CA.C_NOME
                        FROM CKL_ATIVO CA
                        WHERE CA.N_COD_ATIVO = CRC.N_COD_ATIVO)
                    ";
                                            
                    $campoAgrupado = "CRC.N_COD_ATIVO";
                break;

                default: //agrupado por operador

                    $selectNome = "
                        (SELECT INITCAP(LOWER(GNP.C_NOME_RESUMIDO))
                        FROM  GER_USUARIO U
                        INNER JOIN GER_NOME_PESSOA GNP
                        ON (GNP.N_COD_PESSOA = U.N_COD_PESSOA)
                        WHERE U.N_COD_USUARIO = CRC.N_COD_USUARIO)
                    ";
                                            
                    $campoAgrupado = "CRC.N_COD_USUARIO";

            }

            $sqlDadosChecklist = "SELECT $selectNome AS NOME,
                                    COUNT(*) AS TOTAL
                                FROM CKL_RESULTADO_CHECKLIST CRC
                                WHERE CRC.D_INTEGRACAO BETWEEN TO_DATE('$dataInicio', 'YYYY-MM-DD') AND
                                    TO_DATE('$dataTermino', 'YYYY-MM-DD')
                                GROUP BY $campoAgrupado
                                ORDER BY NOME";
            // echo $sqlDadosChecklist; exit;

            $stmtDadosChecklist = oci_parse($con, $sqlDadosChecklist);

            $executouSemErro = oci_execute($stmtDadosChecklist);

            if(!$executouSemErro){

                $retorno['mensagem'][] = "$sqlDadosChecklist";

            }
            else{

                while($rowDadosChecklist = oci_fetch_assoc($stmtDadosChecklist)){

                    $dadosChecklist[] = [
                        "nome" => $rowDadosChecklist['NOME'],
                        "total" => $rowDadosChecklist['TOTAL']
                    ];
                }

                $retorno['dados'] = $dadosChecklist;

            }

        }
        catch(Exception $e){
        
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

                    case "retornaDadosChecklist":
                        echo retornaDadosChecklist(
                            dataInicio:  trim($_GET["dataInicio"]),
                            dataTermino:  trim($_GET["dataTermino"]),
                            agruparPor:  trim($_GET["agruparPor"])
                        );
                    break;
                }
            }

            break;
    }

?>
