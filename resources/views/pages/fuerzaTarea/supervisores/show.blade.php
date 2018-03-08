@extends('layouts.master')

@section('title', $supervisor->nombre)

@section('nav-top')
    @component('components.navbarsearch',[
        'action'    =>  'FuerzaTareaController@searchSupervisoresProduccion',
    ])
    @endcomponent()
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Supervisores' => 'supervisores', $supervisor->nombre => '' ],
    ])
    @endcomponent()
@endsection

@section('content')
    <div class="row" >
        <div class="col-sm-8">
            <div class="media">
                <div class="media-left" >
                    <img src="{{asset('img/supervisor.png')}}" 
                        alt="..." class="img img-responsive" 
                        onerror='this.onerror = null; this.src="/img/user-default.jpg"'
                        style="max-width:100px;"
                        >
                </div>
                <div class="media-body">
                    <h3 class="media-heading title text-truncate" style="margin-top:.8em;">{{ $supervisor->nombre }}
                    </h3>
                    <span class="text-uppercase text-muted">
                        {{ $supervisor->user }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <hr>
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header descarga" data-background-color="orange">
                        <i class="material-icons">arrow_downward</i>
                </div>
                <div class="card-content">
                    <p class="category">Descargas</p>
                    <h3 class="card-title">{{ $productividad->descargas }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">watch_later</i>
                        <span><abbr title="Tiempo Productivo">T.P.</abbr> {{ $productividad->tiempoDescargas }} Hrs.</span>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header carga" data-background-color="orange">
                    <i class="material-icons">arrow_upward</i>
                </div>
                <div class="card-content">
                    <p class="category">Cargas</p>
                    <h3 class="card-title">{{ $productividad->cargas }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">watch_later</i>
                        <span><abbr title="Tiempo Productivo">T.P.</abbr> {{ $productividad->tiempoCargas }} Hrs.</span>
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
                    <h3 class="card-title">{{ $productividad->trasbordos }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">watch_later</i>
                        <span><abbr title="Tiempo Productivo">T.P.</abbr> {{ $productividad->tiempoTrasbordos }} Hrs.</span>
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
                    <h3 class="card-title">{{  $productividad->total }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">watch_later</i>
                        <span><abbr title="Tiempo Productivo">T.P.</abbr> {{ $productividad->tiempoTotal }} Hrs.</span>
                    </div>
                </div>
            </div>
        </div>        

    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">timeline</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Grafica semanal
                    </h4>
                </div>
                <div id="semanaChart" class="ct-chart"></div>
                <div class="card-footer">
                    <i class="fa fa-circle text-info"></i> Descargas
                    <i class="fa fa-circle text-danger"></i> Cargas
                    <i class="fa fa-circle text-warning"></i> Trasbordos
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">pie_chart</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Porcentajes</h4>
                </div>
                <div id="pieChart" class="ct-chart"></div>
                <div class="card-footer">
                    <i class="fa fa-circle text-info"></i> Descargas
                    <i class="fa fa-circle text-danger"></i> Cargas
                    <i class="fa fa-circle text-warning"></i> Trasbordos
                </div>
            </div>
        </div>
    </div>



    <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <ul id="filtros" class="nav nav-pills">
                        <li class="active"><a href data-filter="todos" data-toggle="tab">Todos</a></li>
                        <li><a href data-filter="descargas" data-toggle="tab">Descargas</a></li>
                        <li><a href data-filter="cargas" data-toggle="tab">Cargas</a></li>
                        <li><a href data-filter="trasbordos" data-toggle="tab">Trasbordos</a></li>
                    </ul>
                </div>
            </div>
            <template>
            <div id="oneDate" class="col-md-4 col-md-offset-2">
                <div class="input-group">
                    <span class="input-group-addon">
                        <button type="button" id="view_range_date" title="Agregar rango de fechas" class="btn btn-simple btn-primary btn-just-icon"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></button>
                        <i class="fa fa-calendar "></i> Fecha
                    </span>
                    <input type="text" id="fecha" name="fecha" value="{{$supervisor->fecha->format('j/m/Y')}}" class="form-control"  maxlength="10">
                </div>
            </div>    
            <div id="rangeDate" class="col-md-6 hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <button type="button" id="hide_range_date" title="Quitar rango de fechas" class="btn btn-simple btn-primary btn-just-icon"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i></button>
                                <i class="fa fa-calendar "></i> 
                            </span>
                            <input type="text" id="fechaInicio" placeholder="Desde" class="form-control"  maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar "></i> 
                            </span>
                            <input type="text" id="fechaFinal" placeholder="Hasta" class="form-control"  maxlength="10">
                            <span class="input-group-addon">
                                <button type="button" id="source_date" title="Seleccionar fechas" class="btn btn-simple btn-primary btn-just-icon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </div>
                </div>                
            </div>
            </template>
            </div>
        </div>






    <div class="row">
        <div class="col-md-12">
            <card>
                <template>
                    <div class="material-datatables">
                        <table id="produccionTable" class="table" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Servicio</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Duración</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Servicio</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Duración</th>
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
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()

            var dataPreferences = {
                //labels: ['Descargas','Cargas','Trasbordos'],
                @if ($productividad->total>0)
                    labels: ["{{round($productividad->descargas / $productividad->total * 100,2) }}%" , "{{round($productividad->cargas / $productividad->total * 100,2)}}%", "{{ round($productividad->trasbordos / $productividad->total * 100,2) }}%"],
                    series: [ {{ $productividad->descargas / $productividad->total * 100 }} , {{ $productividad->cargas / $productividad->total * 100 }}, {{ $productividad->trasbordos / $productividad->total * 100 }} ]
                @else
                    labels: ["0%" , "0%", "0%"],
                    series: [ 0, 0, 0 ]
                @endif
            };
    
            var optionsPreferences = {
                height: '230px'
            };
    
            Chartist.Pie('#pieChart', dataPreferences, optionsPreferences);


            dataColouredBarsChart = {
                labels: ['Lun','Mar','Mie','Jue', 'Vie', 'Sab'],
                series: [
                  [
                    {{ $productividad->semana[0]['descargas'] }}, 
                    {{ $productividad->semana[1]['descargas'] }}, 
                    {{ $productividad->semana[2]['descargas'] }}, 
                    {{ $productividad->semana[3]['descargas'] }}, 
                    {{ $productividad->semana[4]['descargas'] }}, 
                    {{ $productividad->semana[5]['descargas'] }}
                  ],
                  [
                    {{ $productividad->semana[0]['cargas'] }}, 
                    {{ $productividad->semana[1]['cargas'] }}, 
                    {{ $productividad->semana[2]['cargas'] }}, 
                    {{ $productividad->semana[3]['cargas'] }}, 
                    {{ $productividad->semana[4]['cargas'] }}, 
                    {{ $productividad->semana[5]['cargas'] }}],

                  [
                    {{ $productividad->semana[0]['trasbordos'] }}, 
                    {{ $productividad->semana[1]['trasbordos'] }}, 
                    {{ $productividad->semana[2]['trasbordos'] }}, 
                    {{ $productividad->semana[3]['trasbordos'] }}, 
                    {{ $productividad->semana[4]['trasbordos'] }}, 
                    {{ $productividad->semana[5]['trasbordos'] }}
                   ]
                ]
              };
      
              optionsColouredBarsChart = {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 10
                }),
                axisY: {
                    showGrid: true,
                    offset: 40
                },
                axisX: {
                    showGrid: false,
                },
                low: 0,
                high: {{  $productividad->total }},
                showPoint: true,
                height: '300px'
              };
            Chartist.Line('#semanaChart', dataColouredBarsChart, optionsColouredBarsChart);

            
            let options = {
                format: 'DD/MM/YYYY',
                useCurrent:true,
                locale: 'es',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove',
                    inline: true
                }
            };
            let fecha = $('#fecha').datetimepicker(options);
            let fechaInicio = $('#fechaInicio').datetimepicker(options);
            let fechaFinal = $('#fechaFinal').datetimepicker(options);
            fechaInicio.on('dp.change', function(e){
                 fechaFinal.data("DateTimePicker").minDate(e.date);   
            });
            fechaFinal.on('dp.change', function(e){
                fechaInicio.data("DateTimePicker").maxDate(e.date);
            });
    
            fecha.on('dp.change', function(e){ 
                let date=$(this).val().replace(/[/]/g,'-');
                
                table.ajax.url( "/supervisors/API/{{$supervisor->id}}/"+date ).load();
                
            });


            let table = $('#produccionTable').DataTable( {
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
                ajax: "/supervisores/API/{{$supervisor->id}}",
                columns:[
                    { 
                        //TIPO
                        "data" : "servicio.tipo",
                        "render":function(data,type,row){
                            return `
                                <p class="${data} letter-icon text-center" title="${data}" >${data.substring(0,1)}</p>
                            `;
                        }
                    },
                    {
                        //SERVICIO
                        "data" : "servicio.cliente.nombre",
                        "render" : function(data, type, row){
                            return `
                                <small class="text-muted">
                                    <i class="fa fa-calendar-o" aria-hidden="true"></i> ${row.date_humans} 
                                    - No. de servicio ${row.servicio.numero_servicio}
                                </small> 
                                <h4>${data}</h4>
                            `;
                        }
                    },
                    { 
                        //INICIO
                        "data" : "horaInicio",
                        "render": function(data, type, row){
                            return `
                                <p class="lead">${data}</p>
                            `
                        }    
                    },
                    {
                        //FIN
                        "data" : "horaFinal",
                        "render" : function(data, type, row){
                            return `
                                <p class="lead">${data}</p>
                            `;
                        }
                    },
                    { 
                        //DURACION
                        "data" : "duracion",
                        "render": function(data, type, row){
                            return `<p class="lead">
                                ${data}
                                </p>
                            `;
                        }
                    }
                ]
            } );
    
            $.fn.dataTable.ext.errMode = 'throw';
    
            $("#filtros").on('click','a',function(){
                switch ($(this).data("filter")) {
                    case 'cargas':
                            console.log("Entra a cargas");
                            table.columns(0).search("^carga",true,false,false).draw();     
                        break;
                    case 'descargas':
                            console.log("Entra a descargas");
                            table.columns(0).search("descarga").draw();     
                        break;
                    case 'trasbordos':
                            console.log("Entra a trasbordo");
                            table.columns(0).search("trasbordo").draw();     
                        break;
                    default:
                            console.log("Entra a default");
                            table.columns(0).search("").draw();     
                        break;
                }
            });

            $('#view_range_date').on('click',function(){
                $("#oneDate").hide();
                $("#rangeDate").fadeIn();
                $("#rangeDate").removeClass("hidden");
                $("#fechaInicio").val('');            
                $("#fechaFinal").val('');            
            });
            $('#hide_range_date').on('click',function(){
                $("#oneDate").fadeIn();
                $("#rangeDate").hide();
            });
    
            $("#source_date").on('click',function(){
                let inicio=$("#fechaInicio");            
                let final=$("#fechaFinal");
                inicio.closest('div.form-group').removeClass('has-error');
                final.closest('div.form-group').removeClass('has-error');
                let fechaInicio = moment(inicio.val(), 'DD/MM/YYYY', true);
                let fechaFinal = moment(final.val(), 'DD/MM/YYYY', true);
                if(!inicio.val() || !final.val()){
                    $.notify({
                        icon: "warning",
                        message: "Debe seleccionar ambas fechas"
    
                    },{
                        type: 'warning',
                        timer: 3000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                    inicio.closest('div.form-group').addClass('has-error');
                    final.closest('div.form-group').addClass('has-error');
                    return;
                } 
                if( fechaInicio.diff(fechaFinal) > -1 ){
                    
                    $.notify({
                        icon: "warning",
                        message: "La fecha inicial no debe ser mayor a la fecha final."
    
                    },{
                        type: 'warning',
                        timer: 3000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                    inicio.val("");
                    final.val("");
                    inicio.closest('div.form-group').addClass('has-error');
                    final.closest('div.form-group').addClass('has-error');
                    return;
                }else{
                    let date=inicio.val().replace(/[/]/g,'-')+"*"+final.val().replace(/[/]/g,'-');
                    table.ajax.url( "/supervisores/API/{{$supervisor->id}}/"+date).load();
                }
            });

        });
    </script>
  @endpush
