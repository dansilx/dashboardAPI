function montaGrafico() {

  let dataInicio = document.getElementById("floatingDataInicio").value;
  let dataTermino = document.getElementById("floatingDataTermino").value;
  let agruparPor = document.getElementById("floatingAgrupamento").value;

  $.ajax({
      type: "GET",
      url: "graficoRespostaChecklistAPI.php",
      data: {
          funcao: "retornaDadosChecklist",
          dataInicio: dataInicio,
          dataTermino: dataTermino,
          agruparPor: agruparPor
      },
      dataType: "JSON",
          
      success: function (response) {
            
        const dados = response.dados.map((item) => ({

          x: item.nome, 
          y: item.total,
          //fillColor: item.colors// 

        }))

        var options = {
          chart: {
            type: "bar",
            width: "100%", // Largura responsiva
            height: "100%", // Altura responsiva
          },
          plotOptions: {
            bar: {
              borderRadius: 4,
              borderRadiusApplication: "end",
              horizontal: true,
              distributed: true, // Habilita cores distribuídas para cada barra
            },
          },
          series: [
            {
              name: "Checklists realizados",
              data: dados,
            },
          ],
      
          xaxis: {
            categories: dados.map(item => item.x),
          },
          title: {
            text: `Checklists realizados no período de ${moment(dataInicio, 'YYYY-MM-DD').format('DD/MM/YYYY')} até ${moment(dataTermino, 'YYYY-MM-DD').format('DD/MM/YYYY')}`,
            align: 'center',
            margin: 10,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
              fontSize:  '25px',
              fontWeight:  'normal',
              fontFamily:  'Roboto, sans-serif',
              color:  '#000'
            },
          },
          // colors: ['#F50000', '#FF6F00', '#FFF200', '#11FF00', '#00FF9D', '#00FFC8', '#008CFF', '#9D00FF', '#FD00CA']//['#80C7FD', '#B39BEB', '#B7DEB6', '#EBC9C7', '#F7EAB5'],

        };

        document.querySelector("#chart").innerHTML = ""
        
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        
        chart.render();
      
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.error("Erro na requisição AJAX:", textStatus, errorThrown);
          resolve(0);
      },
  });
}

montaGrafico();

$('#floatingDataInicio, #floatingDataTermino, #floatingAgrupamento').on('change', function() {
  montaGrafico();
});