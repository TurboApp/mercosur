@extends('layouts.master')


@section('title','Cliente: '.str_limit($cliente->nombre, 24))

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Clientes' => 'clientes',  $cliente->nombre => '' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        @if(auth()->user()->perfil->perfil == 'admin')
        <li>
            <a href="/clientes/{{ $cliente->id }}/editar" title="Editar">
                <i class="material-icons">edit</i>
                <p class="hidden-lg hidden-md">Editar</p>
            </a>
        </li>
        <li>
            <a href="#" class=" delete-cliente" title="Eliminar">
                <i class="material-icons">delete</i>
                <p class="hidden-lg hidden-md">Eliminar</p>
            </a>
        </li>
        <li>
            <a href="/clientes/nuevo"  title="Agregar nuevo">
                <i class="material-icons">person_add</i>
                <p class="hidden-lg hidden-md">Agregar</p>
            </a>
        </li>
        @endif
        <li>
            <a href="/clientes" title="Ir a clientes">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a clientes</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>

    @component('components.navbarsearch',[
        'action'    => 'ClienteController@search',
    ])
    @endcomponent()
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border-radius:6px;">
            <div class="card-content content-info" style="border-radius:6px;">
                <h6 class="category-social"><i class="fa fa-line-chart" aria-hidden="true"></i> Metricas</h6>
                <h2 class="card-title" >
                        {{$cliente->nombre_corto}}
                </h2>
                <p>
                    {{$cliente->nombre}}
                </p>
            </div>
        </div>
    </div>
</div>
    

    <div class="row">
        <div class="col-md-4">
            <div class="card card-chart" >
                <div class="card-header descarga" data-background-color="rose" style="border-radius:6px;">
                    <div id="semanaDescargaChart" class="ct-chart">
                        
                    </div>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Descargas</h4>
                    <p class="category">{{$cliente->totalSemanaDescarga}} durante la semana.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-chart">
                <div class="card-header carga" data-background-color="orange" style="border-radius:6px;">
                    <div id="semanaCargaChart" class="ct-chart">
                        
                    </div>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Cargas</h4>
                    <p class="category">{{$cliente->totalSemanaCarga}} durante la semana.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-chart">
                <div class="card-header trasbordo" data-background-color="blue" style="border-radius:6px;">
                    <div id="semanaTrasbordoChart" class="ct-chart">
                        
                    </div>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Trasbordos</h4>
                    <p class="category">{{$cliente->totalSemanaTrasbordo}} durante la semana.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-6">
            <div class="card card-stats">
                <div class="card-header descarga" data-background-color="orange">
                    <i class="material-icons">arrow_downward</i>
                </div>
                <div class="card-content">
                    <p class="category">Descargas</p>
                    <h3 class="card-title">{{$cliente->descargasTotalMes}}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        Total de descargas durante el mes
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-6">
            <div class="card card-stats">
                <div class="card-header carga" data-background-color="orange">
                    <i class="material-icons">arrow_upward</i>
                </div>
                <div class="card-content">
                    <p class="category">Cargas</p>
                    <h3 class="card-title">{{$cliente->cargasTotalMes}}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        Total de cargas durante el mes
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header trasbordo" data-background-color="orange">
                    <i class="material-icons">compare_arrows</i>
                </div>
                <div class="card-content">
                    <p class="category">Trasbordos</p>
                    <h3 class="card-title">{{$cliente->trasbordoTotalMes}}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        Total de trasbordos del mes
                    </div>
                </div>
            </div>
        </div>        
        
        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="rose">
                    <i class="material-icons">done</i>
                </div>
                <div class="card-content">
                    <p class="category">Total</p>
                    <h3 class="card-title">{{$cliente->totalMes}}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        Total de servicios durante el mes
                    </div>
                </div>
            </div>
        </div>        
    
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="primary">
                    <i class="material-icons">insert_chart</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title"> Servicios por mes durante el año </h4>
                </div>
                <div id="metricaByYear" class="ct-chart"></div>
                <div class="card-footer">
                    <div class="stats">
                            <i class="fa fa-circle text-info"></i> Descargas
                            <i class="fa fa-circle text-danger"></i> Cargas
                            <i class="fa fa-circle text-warning"></i> Trasbordos
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="primary">
                    <i class="material-icons">pie_chart</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Porcentajes totales</h4>
                </div>
                <div id="pieChart" class="ct-chart"></div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="fa fa-circle text-info"></i> Descargas ({{ $cliente->descargasTotal }}) 
                        <i class="fa fa-circle text-danger"></i> Cargas ({{ $cliente->cargasTotal }})  
                        <i class="fa fa-circle text-warning"></i> Trasbordos ({{ $cliente->trasbordosTotal }})
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <card>
                <template>
                    <div class="material-datatables">
                        <table id="metricaByYearTable" class="table" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Año</th>
                                    <th>Descarga</th>
                                    <th>Carga</th>
                                    <th>Trasbordo</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Año</th>
                                    <th>Descarga</th>
                                    <th>Carga</th>
                                    <th>Trasbordo</th>
                                    <th>Total</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </template>
            </card>
        </div>
    </div>

@endsection

@push('scripts')
  
  @include('layouts.partials.notify')

  @include("layouts.partials.confirmDelete", ["url" => "/clientes/$cliente->id/destroy", "class" => "delete-cliente", "redirect" => "/clientes" ])
  
  <script>
        {{--  Metricas por semana --}}
        //Descargas
        new Chartist.Line('#semanaDescargaChart', {
            labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            series: [
                [
                    {{ $cliente->semana[0]['descargas'] }}, 
                    {{ $cliente->semana[1]['descargas'] }}, 
                    {{ $cliente->semana[2]['descargas'] }}, 
                    {{ $cliente->semana[3]['descargas'] }}, 
                    {{ $cliente->semana[4]['descargas'] }}, 
                    {{ $cliente->semana[5]['descargas'] }}
                ]
            ]
          }, {
            fullWidth: true,
            chartPadding: {
              right: 40
            }
          });

        new Chartist.Line('#semanaCargaChart', {
            labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            series: [
                [
                    {{ $cliente->semana[0]['cargas'] }}, 
                    {{ $cliente->semana[1]['cargas'] }}, 
                    {{ $cliente->semana[2]['cargas'] }}, 
                    {{ $cliente->semana[3]['cargas'] }}, 
                    {{ $cliente->semana[4]['cargas'] }}, 
                    {{ $cliente->semana[5]['cargas'] }}
                ]
            ]
          }, {
            fullWidth: true,
            chartPadding: {
              right: 40
            }
          });
        new Chartist.Line('#semanaTrasbordoChart', {
            labels: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            series: [
                [
                    {{ $cliente->semana[0]['trasbordos'] }}, 
                    {{ $cliente->semana[1]['trasbordos'] }}, 
                    {{ $cliente->semana[2]['trasbordos'] }}, 
                    {{ $cliente->semana[3]['trasbordos'] }}, 
                    {{ $cliente->semana[4]['trasbordos'] }}, 
                    {{ $cliente->semana[5]['trasbordos'] }}
                ]
            ]
          }, {
            fullWidth: true,
            chartPadding: {
              right: 40
            }
          });
        
          var MetricYear = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            series: [
                  [  @foreach ($cliente->metricaByYear['descargas'] as $item)
                        {{$item}},
                    @endforeach
                    ],
                    [  @foreach ($cliente->metricaByYear['cargas'] as $item)
                        {{$item}},
                    @endforeach
                    ],
                    [  @foreach ($cliente->metricaByYear['trasbordos'] as $item)
                        {{$item}},
                    @endforeach
                    ],
                
                
            ]
            };
            
            var options = {
            seriesBarDistance: 10
            };
            
            var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                labelInterpolationFnc: function (value) {
                    return value[0];
                }
                }
            }]
            ];
            
            new Chartist.Bar('#metricaByYear', MetricYear, options, responsiveOptions);

            {{-- Total de servicios --}}  
            var dataPreferences = {
                //labels: ['Descargas','Cargas','Trasbordos'],
                @if ($cliente->totalServicios > 0)
                    labels: ["{{round($cliente->descargasTotal / $cliente->totalServicios * 100,2) }}%" , "{{round($cliente->cargasTotal / $cliente->totalServicios * 100,2)}}%", "{{ round($cliente->trasbordosTotal / $cliente->totalServicios * 100,2) }}%"],
                    series: [ {{ $cliente->descargasTotal / $cliente->totalServicios * 100 }} , {{ $cliente->cargasTotal / $cliente->totalServicios * 100 }}, {{ $cliente->trasbordosTotal / $cliente->totalServicios * 100 }} ]
                @else
                    labels: ["0%" , "0%", "0%"],
                    series: [ 0, 0, 0 ]
                @endif
            };
    
            var optionsPreferences = {
                height: '230px'
            };
    
            Chartist.Pie('#pieChart', dataPreferences, optionsPreferences);
           




        ///TABLE
        let table = $('#metricaByYearTable  ').DataTable( {
            order: [],
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                sInfoPostFix: "",
                sSearch: "Buscar:",
                sUrl: "",
                sInfoThousands: ",",
                sLoadingRecords: "Cargando...",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                },
                oAria: {
                    sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            },
            ajax: "/clientes/API/{{$cliente->id}}",
            columns:[
                { 
                    "data" : "year",
                },
                {
                    "data" : "descargas",
                },
                { 
                    "data" : "cargas",
                },
                {
                    "data" : "trasbordos",
                },
                { 
                    "data" : "total",
                }
            ]
        } );

        $.fn.dataTable.ext.errMode = 'throw';
        
  </script>

@endpush