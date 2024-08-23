<?php

namespace Plantae\Api\routes;

require_once ("../../vendor/autoload.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH");


use Plantae\Api\utils\Conexao;
use Plantae\Api\utils\Funcoes;

use Exception;

function Vencidos()
{

    $retorno = Funcoes::getRetorno();

    try {
        $sql = "
                SELECT 
                    TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY')                         AS VENCIMENTO, 
                    T.N_COD_CONTRATO                                            AS NRO_CONTRATO, 
                    T.C_NOME                                                    AS NOME_CLIENTE,
                    REPLACE(REPLACE(T.V_VALOR_PREST,'.',''),',','.')            AS VALOR_PRESTACAO,
                    REPLACE(REPLACE(T.V_JUROS,'.','') ,',','.')                 AS VALOR_MORA
                FROM temp_parcelas_homolog T
                WHERE T.D_VENCIMENTO <> '0'
                AND T.D_VENCIMENTO IS NOT NULL
                AND T.C_STATUS = 'VC'
                ORDER BY T.D_VENCIMENTO DESC
            ";

        $rows = Conexao::getInstancia()->buscarTodos($sql);

        $arr = [];

        foreach ($rows as $row) {

            $dataVencimento = \DateTime::createFromFormat('d/m/y', $row['VENCIMENTO']);

            $arr[] = [
                "vencimento" =>     $dataVencimento->format('Y-m-d'),
                "numeroContrato" => $row["NRO_CONTRATO"],
                "cliente" =>        $row["NOME_CLIENTE"],
                "valorPrestacao" => (float) $row["VALOR_PRESTACAO"],
                "valorMora" =>      (float) $row["VALOR_MORA"]
            ];
        }

        $retorno["dados"] = $arr;

        http_response_code(200);
    } catch (Exception $e) {
        $retorno["erro"] == true;
        $retorno["mensagem"] = $e->getMessage();

        http_response_code(400);
    }

    Conexao::getInstancia()->fecharConexao();
    header('Content-Type: Application/json; charset=utf-8');
    return json_encode($retorno);
}

function AVencer()
{

    $retorno = Funcoes::getRetorno();

    try {
        $sql = "
                SELECT
                    TO_DATE(T.D_VENCIMENTO,'DD/MM/YY')                          AS VENCIMENTO, 
                    T.C_NOME                                                    AS NOME_CLIENTE,
                    T.N_COD_CONTRATO                                            AS NRO_CONTRATO,
                    REPLACE(REPLACE(T.V_VALOR_PREST,'.','') ,',','.')           AS VALOR_PRESTACAO
                FROM temp_parcelas_homolog T
                WHERE T.D_VENCIMENTO <> '0'
                AND T.D_VENCIMENTO IS NOT NULL
                AND T.C_STATUS = 'AV'
                ORDER BY T.D_VENCIMENTO DESC
            ";

        $rows = Conexao::getInstancia()->buscarTodos($sql);

        $arr = [];

        foreach ($rows as $row) {

            $dataVencimento = \DateTime::createFromFormat('d/m/y', $row['VENCIMENTO']);

            $arr[] = [
                "vencimento" => $dataVencimento->format('Y-m-d'),
                "numeroContrato" => $row["NRO_CONTRATO"],
                "cliente" => $row["NOME_CLIENTE"],
                "valorPrestacao" => (float) $row["VALOR_PRESTACAO"],
            ];
        }

        $retorno["dados"] = $arr;

        http_response_code(200);
    } catch (Exception $e) {
        $retorno["erro"] == true;
        $retorno["mensagem"] = $e->getMessage();

        http_response_code(400);
    }

    Conexao::getInstancia()->fecharConexao();
    header('Content-Type: Application/json; charset=utf-8');
    return json_encode($retorno);
}

function AVencerAnual()
{

    $retorno = Funcoes::getRetorno();

    try {
        $sql = "
                SELECT 
                    ANO AS ANO,
                    REPLACE(SUM(VALOR), ',', '.') AS VALOR,
                    QUANTIDADE_VENCIMENTOS,
                    REPLACE(ROUND(VALOR / (SUM(VALOR) OVER()), 4), ',', '.') AS PORCENTAGEM
                FROM (SELECT TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'YYYY') AS ANO,
                            SUM(TO_NUMBER(REPLACE(T.V_TOTAL, '.', ''))) AS VALOR,
                            COUNT(1) AS QUANTIDADE_VENCIMENTOS
                        FROM TEMP_PARCELAS_HOMOLOG T
                        WHERE T.D_VENCIMENTO <> '0'
                        AND T.D_VENCIMENTO IS NOT NULL
                        AND T.C_STATUS = 'AV'
                        GROUP BY TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'YYYY')
                        ORDER BY ANO ASC)
                GROUP BY ANO, QUANTIDADE_VENCIMENTOS, VALOR

            ";

        $rows = Conexao::getInstancia()->buscarTodos($sql);

        $arr = [];

        foreach ($rows as $row) {

            $arr[] = [
                "ano" => (int) $row["ANO"],
                "quantidade" => (float) $row["QUANTIDADE_VENCIMENTOS"],
                "valorPrestacao" => (float) $row["VALOR"],
                "porcentagem" => (float) $row["PORCENTAGEM"],
            ];
        }

        $retorno["dados"] = $arr;

        http_response_code(200);
    } catch (Exception $e) {
        $retorno["erro"] == true;
        $retorno["mensagem"] = $e->getMessage();

        http_response_code(400);
    }

    Conexao::getInstancia()->fecharConexao();
    header('Content-Type: Application/json; charset=utf-8');
    return json_encode($retorno);
}



function AgrupadoPorProduto()
{

    $retorno = Funcoes::getRetorno();

    try {
        $sql = "
                SELECT 
                    TRIM(UPPER(T.C_DESC_PRODUTO))                                     AS PRODUTO,
                    REPLACE(SUM(TO_NUMBER(REPLACE(T.V_VALOR_TOTAL,'.',''))),',','.')  AS VALOR
                FROM TEMP_CONTRATOS_HOMOLOG T
                GROUP BY TRIM(UPPER(T.C_DESC_PRODUTO))
                ORDER BY VALOR
            ";

        $rows = Conexao::getInstancia()->buscarTodos($sql);

        $arr = [];

        foreach ($rows as $row) {

            $arr[] = [
                "produto" => $row["PRODUTO"],
                "valor" => (float) $row["VALOR"],
            ];
        }

        $retorno["dados"] = $arr;

        http_response_code(200);
    } catch (Exception $e) {
        $retorno["erro"] == true;
        $retorno["mensagem"] = $e->getMessage();

        http_response_code(400);
    }

    Conexao::getInstancia()->fecharConexao();
    header('Content-Type: Application/json; charset=utf-8');
    return json_encode($retorno);
}

function AVencerAgrupadoPorPeriodo()
{

    $retorno = Funcoes::getRetorno();

    try {
        $sql = "
                SELECT TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'yyyy') AS ANO,
                    TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'MM') AS MES,
                    TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'DD') AS DIA,
                    SUM(TO_NUMBER(REPLACE(T.V_VALOR_PREST, '.', ''))) AS VALOR_PRESTACAO
                FROM TEMP_PARCELAS_HOMOLOG T
                WHERE T.D_VENCIMENTO <> '0'
                AND T.D_VENCIMENTO IS NOT NULL
                AND T.C_STATUS = 'AV'
                GROUP BY TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'yyyy'),
                        TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'MM'),
                        TO_CHAR(TO_DATE(T.D_VENCIMENTO, 'DD/MM/YY'), 'DD')
                ORDER BY ANO, MES, DIA
            ";

        $rows = Conexao::getInstancia()->buscarTodos($sql);

        $arr = [];

        foreach ($rows as $row) {

            $arr[] = [
                "ano" => $row["ANO"],
                "mes" => $row["MES"],
                "dia" => $row["DIA"],
                "valorPrestacao" => (float) $row["VALOR_PRESTACAO"],
            ];
        }

        $retorno["dados"] = $arr;

        http_response_code(200);
    } catch (Exception $e) {
        $retorno["erro"] == true;
        $retorno["mensagem"] = $e->getMessage();

        http_response_code(400);
    }

    Conexao::getInstancia()->fecharConexao();
    header('Content-Type: Application/json; charset=utf-8');
    return json_encode($retorno);
}

function ValoresCards() {
    $retorno = Funcoes::getRetorno();
    $arr = [];

    try {
        // PEGA VALORS DO VENCIMENTO
        $sql = "
                SELECT 
                    REPLACE(SUM((CASE
                                    WHEN T.C_STATUS = 'VC' THEN
                                    TO_NUMBER(NVL(REPLACE(T.V_VALOR_PREST, '.', ''), 0))
                                    ELSE
                                    0
                                END)),
                            ',',
                            '.') AS VALOR_TOTAL_PRESTACAO_VENCIDA,
                            
                    REPLACE(SUM((CASE
                                    WHEN T.C_STATUS = 'AV' THEN
                                    TO_NUMBER(NVL(REPLACE(T.V_VALOR_PREST, '.', ''), 0))
                                    ELSE
                                    0
                                END)),
                            ',',
                            '.') AS VALOR_TOTAL_PRESTACAO_A_VENCER,
                    REPLACE(SUM(TO_NUMBER(NVL(REPLACE(T.V_JUROS,'.',''),0))),',','.')       AS VALOR_TOTAL_MORA
                FROM temp_parcelas_homolog T
                WHERE T.D_VENCIMENTO <> '0'
                AND T.D_VENCIMENTO IS NOT NULL
            ";

        $sqlQuantidadeClientes = "SELECT COUNT(1) AS QUANTIDADE
            FROM (SELECT DISTINCT T.N_COD_CLIENTE
                    FROM TEMP_PARCELAS_HOMOLOG T
                    WHERE T.D_VENCIMENTO <> '0'
                    AND T.D_VENCIMENTO IS NOT NULL)";
                    

         $sqlProdutoMaisVendido = " SELECT T.C_DESC_COMPL,
                       SUM(TO_NUMBER(REPLACE(T.V_VALOR_PREST, '.', ''))) AS TOTAL
                  FROM TEMP_PARCELAS_HOMOLOG T
                 WHERE T.D_VENCIMENTO <> '0'
                   AND T.D_VENCIMENTO IS NOT NULL
                 GROUP BY T.C_DESC_COMPL
                 ORDER BY TOTAL DESC
                 FETCH FIRST 1 ROWS ONLY
            ";

        $row = Conexao::getInstancia()->buscar($sql);
        $rowQuantidadeClientes = Conexao::getInstancia()->buscar($sqlQuantidadeClientes);
        $rowProdutoMaisVendido = Conexao::getInstancia()->buscar($sqlProdutoMaisVendido);

        $arr["valorTotalVencido"]       = $row["VALOR_TOTAL_PRESTACAO_VENCIDA"];
        $arr["valorTotalAVencer"]       = $row["VALOR_TOTAL_PRESTACAO_A_VENCER"];
        $arr["valorTotalMora"]          = $row["VALOR_TOTAL_MORA"];

        $arr["quantidadeClientes"]          = $rowQuantidadeClientes["QUANTIDADE"];

        $arr["produtoMaisVendido"]     = $rowProdutoMaisVendido["C_DESC_COMPL"];

        $retorno["dados"] = $arr;
        http_response_code(200);

    } catch (Exception $e) {
        $retorno["erro"] == true;
        $retorno["mensagem"] = $e->getMessage();

        http_response_code(400);
    }

    Conexao::getInstancia()->fecharConexao();
    header('Content-Type: Application/json; charset=utf-8');
    return json_encode($retorno);
}



switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["funcao"])) {

            switch ($_GET["funcao"]) {
                case "Vencidos":
                    echo Vencidos();
                    break;

                case "AVencer":
                    echo AVencer();
                    break;

                case "AVencerAnual":
                    echo AVencerAnual();
                    break;

                    
                case "AVencerAgrupadoPorPeriodo":
                    echo AVencerAgrupadoPorPeriodo();
                    break;

                case "AgrupadoPorProduto":
                    echo AgrupadoPorProduto();
                    break;

                case "ValoresCards":
                    echo ValoresCards();
                    break;
            }
        }
        break;

    case "POST":
        break;
}