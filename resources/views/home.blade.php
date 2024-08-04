@extends('bases.base')
@section('content')
    
    <div class="row">
        <div class="col-md-4">

                {{-- <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center">
                      <h5 class="mb-0">Datos Generales</h5>
                      <i class="ph-duotone ph-info f-20 ms-1" data-bs-toggle="tooltip" data-bs-title="Conversion Rate"></i>
                    </div>
        
                  </div>
                  <div class="table-body card-body pt-0 px-0">
                    <div class="table-responsive">
                      <table class="table table-borderless mb-0">
                        <tbody>
                          <tr>
                            <td>
                              <h6 class="f-w-500 mb-0">Expedientes Aperturados</h6>
                              <span class="d-block text-muted"><p id="txtAperturados"></p></span>
                            </td>
                            
                          </tr>
                          <tr>
                            <td>
                              <h6 class="f-w-500 mb-0">Expedientes No Aperturados</h6>
                              <span class="d-block text-muted"><p id="txtNoAperturados"></p></span>
                            </td>
                            
                          </tr>
                          <tr>
                            <td>
                              <h6 class="f-w-500 mb-0">Total Expedientes</h6>
                              <span class="d-block text-muted"><p id="txttotalExpedientes"></p></span>
                            </td>
                            
                          </tr>
                          <tr>
                            <td>
                              <h6 class="f-w-500 mb-0">Total Ejecutados</h6>
                              <span class="d-block text-muted"><p id="txttotalEjecutados"></p></span>
                            </td>
                            
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div> --}}
              

        </div>
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>Recaudado por Mes</h5>
                    <div id="grafico_barra">

                    </div>
                </div>
            </div>
        </div> --}}
    </div>


    
@endsection

@section('js')
    <script src="../../../assets/js/plugins/apexcharts.min.js"></script>
    
    <script>
    //    $.ajax({
    //        type: "GET",
    //        url: "/graficos/datos",
    //        dataType: "json",
    //        success: function (response) {
    //            grafico_pagos_mensuales(response.data.pagos)
    //            datos_generales(
    //                response.data.aperturados,
    //                response.data.noaperturados,
    //                response.data.totalexpedientes,
    //                response.data.totalejecutados,
    //            )
//
    //        }
    //    });
//
    //    function datos_generales(aperturados,noaperturados,totalexpedientes,total_ejecutados) { 
    //        $("#txtAperturados").text(aperturados);
    //        $("#txtNoAperturados").text(noaperturados);
    //        $("#txttotalExpedientes").text(totalexpedientes);
    //        $("#txttotalEjecutados").text(total_ejecutados);
    //    }
//
    //    function grafico_pagos_mensuales(data) { 
//
    //        const datos = [];
    //        const categorias = [];
//
    //        data.forEach(element => {
    //            datos.push(element.total_pagos)
    //            categorias.push(element.mes_nombre)
    //        });
//
    //        var options = {
    //            series: [{
    //            name: 'Total Pago',
    //            data: datos
    //            }],
    //            chart: {
    //            height: 350,
    //            type: 'bar',
    //            },
    //            plotOptions: {
    //            bar: {
    //                borderRadius: 10,
    //                dataLabels: {
    //                position: 'top', // top, center, bottom
    //                },
    //            }
    //            },
    //            dataLabels: {
    //            enabled: true,
    //            formatter: function (val) {
    //                return "S/ "+val;
    //            },
    //            offsetY: -20,
    //            style: {
    //                fontSize: '12px',
    //                colors: ["#304758"]
    //            }
    //            },
    //            
    //            xaxis: {
    //            categories: categorias,
    //            position: 'top',
    //            axisBorder: {
    //                show: false
    //            },
    //            axisTicks: {
    //                show: false
    //            },
    //            crosshairs: {
    //                fill: {
    //                type: 'gradient',
    //                gradient: {
    //                    colorFrom: '#D8E3F0',
    //                    colorTo: '#BED1E6',
    //                    stops: [0, 100],
    //                    opacityFrom: 0.4,
    //                    opacityTo: 0.5,
    //                }
    //                }
    //            },
    //            tooltip: {
    //                enabled: true,
    //            }
    //            },
    //            yaxis: {
    //            axisBorder: {
    //                show: false
    //            },
    //            axisTicks: {
    //                show: false,
    //            },
    //            labels: {
    //                show: false,
    //                formatter: function (val) {
    //                return "S/ "+val;
    //                }
    //            }
    //            
    //            },
    //            title: {
    //            text: 'Pagos de los ultimos 6 meses',
    //            floating: true,
    //            offsetY: 330,
    //            align: 'center',
    //            style: {
    //                color: '#444'
    //            }
    //            }
    //            };
//
    //            var chart = new ApexCharts(document.querySelector("#grafico_barra"), options);
    //            chart.render();
//
//
    //        
    //    }
          
      
    </script>
@endsection