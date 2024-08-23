const locale = 'pt'
const routeAPI = '../apis/dashboard/';


function graficoCanvas()
{
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
}


async function buscaBancoSaldo() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: `${routeAPI}dsh_b001_API.php?funcao=BancoSaldo`,
            // data: "data",
            dataType: "JSON",
            success: function (retorno) {
                resolve(retorno.dados);
            },
            error: function(){
                resolve([]);
            }
        });
    })
}

// async function buscaCarteirasVPPorProduto() {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             type: "GET",
//             url: `${routeAPI}Carteira.php?funcao=AgrupadoPorProduto`,
//             // data: "data",
//             dataType: "JSON",
//             success: function (retorno) {
//                 resolve(retorno.dados);
//             },
//             error: function(){
//                 resolve([]);
//             }
//         });
//     })
// }

$(document).ready(function () {
    
    //espera a importação das libs do devextreme
    $.when(
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/main/"+locale+"/ca-gregorian.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/main/"+locale+"/numbers.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/main/"+locale+"/currencies.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/supplemental/likelySubtags.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/supplemental/timeData.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/supplemental/weekData.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/supplemental/currencyData.json"),
        $.getJSON("./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/supplemental/numberingSystems.json")
    ).then(function () {
        //The following code converts the loaded results into an array
        return [].slice.apply(arguments, [0]).map(function (result) {
            return result[0];
        });
    }).then(
        Globalize.load
    ).then(function () {
        Globalize.locale(locale);
        DevExpress.config({
            defaultCurrency: "BRL",
        });
        
        

        Promise.all([
            buscaBancoSaldo(),
        ]).then(([buscBancoSaldo]) => {
                
            //cria a tabela de carteira vencida
            $('#containerBuscaSaldo').dxDataGrid
            ({
                dataSource: { // o array de objetos com as informações da conta
                    store: {
                        type: 'array',
                        key: 'ID', 
                        data: dados
                    }
                },
                
                allowColumnReordering: true,
                showBorders: true,
                
                columns: [
                    {
                        dataField: 'conta',
                        caption: 'Banco e Agência',
                        dataType: 'string',
                        alignment: 'center',
                        sortOrder: 'asc'
                    },
                    {
                        caption: 'Limite e Taxa', // Título da coluna combinada
                        alignment: 'right',
                        cellTemplate(container, options) {
                            const limite = options.data.limite;
                            const taxa = options.data.taxa;
                            const html = `
                                <div>
                                    LIMITE C/C ${DevExpress.localization.formatNumber(limite, { type: 'currency', precision: 2 })} 
                                    - Tx: ${DevExpress.localization.formatNumber(taxa, { type: 'fixedPoint', precision: 2 })}%
                                </div>`;
                            container.html(html);
                        }
                    },
                    {
                        dataField: 'saldoAnterior',
                        caption: 'Saldo Anterior',
                        dataType: 'number',
                        format: {
                            type: 'currency',
                            precision: 2
                        },
                        alignment: 'right',
                    },
                    {
                        dataField: 'lancamentos',
                        caption: 'Lançamentos',
                        dataType: 'array',
                        cellTemplate(container, options) {
                            let lancamentos = options.value;
                            var html = '<ul>';
                            lancamentos.forEach(function(lancamento) {
                                html += `<li>${lancamento.DECRICAO}: ${DevExpress.localization.formatNumber(lancamento.LANCAMENTO, { type: 'currency', precision: 2 })}</li>`;
                            });
                            html += '</ul>';
                            container.html(html);
                        },
                    },
                    {
                        dataField: 'saldoEmCC',
                        caption: 'Saldo em C/C',
                        dataType: 'number',
                        format: {
                            type: 'currency',
                            precision: 2
                        },
                        alignment: 'right',
                    },
                    {
                        dataField: 'saldoAplicacoes',
                        caption: 'Saldo em Aplicações',
                        dataType: 'number',
                        format: {
                            type: 'currency',
                            precision: 2
                        },
                        alignment: 'right',
                    },
                    {
                        dataField: 'totalDisponivel',
                        caption: 'Total Disponível',
                        dataType: 'number',
                        format: {
                            type: 'currency',
                            precision: 2
                        },
                        alignment: 'right',
                    },
                ],
                masterDetail: {
                    enabled: true,
                    template: function(container, options) {
                        let dadosBanco = buscaBancoSaldo[options.key - 1];
                        $("<div>").dxDataGrid({
                            dataSource: 
                        })
                        .appendTo(container);
                    }

                },
            
                summary: {
                    totalItems: [
                        {
                            column: 'saldoAnterior',
                            summaryType: 'sum',
                            valueFormat: 'currency',
                            alignment: 'right',
                        },
                        {
                            column: 'saldoEmCC',
                            summaryType: 'sum',
                            valueFormat: 'currency',
                            alignment: 'right',
                        },
                        {
                            column: 'saldoAplicacoes',
                            summaryType: 'sum',
                            valueFormat: 'currency',
                            alignment: 'right',
                        },
                        {
                            column: 'totalDisponivel',
                            summaryType: 'sum',
                            valueFormat: 'currency',
                            alignment: 'right',
                        }
                    ],
                },
            });
            


            // //cria o gráfico dos produtos
            // $('#carteiraVPPorProduto').dxChart({
            //     dataSource: carteiraPorProduto,
            //     series: {
            //         argumentField: 'produto',
            //         valueField: 'valor',

            //         name: 'Produtos',
            //         type: 'bar',
            //         color: '#149161e6',
            //     },
            //     legend: {
            //         visible: false // Esconde a legenda
            //     },
            //     customizeLabel() {
            //         return {
            //             visible: true,
            //             customizeText() {
            //                 return `${(this.value / 1000 / 1000).toFixed(2).replace('.', ',')}`;
            //             },
            //         };
            //     },

            //     rotated: true
            // });


            // //cria a tabela de carteira a vencer
            // $('#containerCarteiraAVencer').dxDataGrid({
            //     dataSource: carteirasAVencer,
            //     allowColumnReordering: true,
                
            //     searchPanel: {
            //         visible: true,
            //         highlightCaseSensitive: true,
            //     },

            //     columns: [
            //         {
            //             dataField: 'vencimento',
            //             caption: 'Vencerá em',
            //             dataType: 'date',
            //             alignment: 'center',
            //             sortOrder: 'asc'
            //         },

            //         {
            //             dataField: 'numeroContrato',
            //             caption: 'Contrato',
            //             dataType: 'string',
            //             alignment: 'right',
            //             sortOrder: 'asc'
            //         },

            //         {
            //             dataField: 'cliente',
            //             caption: 'Cliente',
            //             dataType: 'string',
            //             alignment: 'left',
            //         },

            //         {
            //             dataField: 'valorPrestacao',
            //             caption: 'Prestação',
            //             dataType: 'number',
            //             format: 'currency',
            //             alignment: 'right',
            //         },
            //     ],

            //     summary: {
            //         totalItems: [
            //             {
            //                 column: 'dataVencimento',
            //                 summaryType: 'count',
            //                 customizeText(itemInfo) {
            //                     if (itemInfo.value == 1)
            //                         return `${itemInfo.value} Contrato`;

            //                     return `${itemInfo.value} Contratos`;
            //                 },
            //             }, 

            //             {
            //                 column: 'valorPrestacao',
            //                 summaryType: 'sum',
            //                 valueFormat: 'currency',
            //             },

            //         ],
            //     },

            //     showBorders: true,
            // });


            // // //cria a tabela de carteira a vencer agrupada por ano
            // $('#containerCarteiraAVencerAgrupadaAnual').dxDataGrid({
            //     dataSource: carteirasAVencerAgrupadoPorAno,
            //     allowColumnReordering: true,
                
            //     searchPanel: {
            //         visible: true,
            //         highlightCaseSensitive: true,
            //     },

            //     columns: [
            //         {
            //             dataField: 'ano',
            //             caption: 'Vencerá em',
            //             dataType: 'number',
            //             alignment: 'center',
            //             sortOrder: 'asc',
            //         },


            //         {
            //             dataField: 'quantidade',
            //             caption: 'Quantidade',
            //             dataType: 'number',
            //             format: '',
            //             alignment: 'right',
            //         },


            //         {
            //             dataField: 'valorPrestacao',
            //             caption: 'Prestação',
            //             dataType: 'number',
            //             format: 'currency',
            //             alignment: 'right',
            //         },

            //         {
            //             dataField: 'porcentagem',
            //             caption: '%',
            //             dataType: 'number',
            //             format: 'percent',
            //             alignment: 'right',
            //         },
            //     ],

            //     summary: {
            //         totalItems: [

            //             {
            //                 column: 'valorPrestacao',
            //                 summaryType: 'sum',
            //                 valueFormat: 'currency',
            //             },

            //             {
            //                 column: 'quantidade',
            //                 summaryType: 'sum',
            //                 valueFormat: '',
            //             },

            //             {
            //                 column: 'porcentagem',
            //                 summaryType: 'sum',
            //                 valueFormat: 'percent',
            //             },

            //         ],
            //     },

            //     showBorders: true,
            // });

            // let totalVencido = cards.valorTotalVencido || 0;
            // let totalAVencer = cards.valorTotalAVencer || 0;
            // let quantidadeClientes = cards.quantidadeClientes || 0;
            // let produto = cards.produtoMaisVendido;

            // // console.log(cards)

            // $('#cardTotalVencido').attr('data-valor', new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(totalVencido))
            // $('#cardTotalAVencer').attr('data-valor', new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(totalAVencer))
            // $('#cardQuantidadeClientes').attr('data-quantidade', quantidadeClientes)
            // $('#cardProdutoMaisVendido').attr('data-produto', produto)
        })        
        
    })

});