<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Resposta Checklist</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="./graficoRespostaChecklist.css?_<?=filemtime('./graficoRespostaChecklist.css')?>">
</head>
<body>
    <div class="container-fluid">

        <div class="row row-cols-2">

            <div class="col-2">
                <div class="form-floating">
                    
                    <input id="floatingDataInicio" type="date" class="form-control" placeholder="" aria-label="Data início" value="<?=date('Y-m-');?>01">

                    <label for="floatingDataInicio">Data Início</label>

                </div>

            </div>
            <div class="col-2">
                <div class="form-floating">
                    
                    <input id="floatingDataTermino" type="date" class="form-control" placeholder="" aria-label="Data término" value="<?=date('Y-m-t');?>">

                    <label for="floatingDataTermino">Data Término</label>

                </div>
            </div>

            <div class="col-4">
                <div class="form-floating">

                    <select class="form-select" id="floatingAgrupamento" aria-label="Agrupado por">
                        <option value="operador" selected>Operador</option>
                        <option value="ativo">Ativo</option>
                    </select>

                    <label for="floatingAgrupamento">Agrupar por</label>
                </div>
            </div>

        </div>

    </div>


    <div id="chart"></div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="./graficoRespostaChecklist.js?_<?=filemtime('./graficoRespostaChecklist.js')?>"></script>
</body>
</html>