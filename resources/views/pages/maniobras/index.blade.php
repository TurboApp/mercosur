@extends('layouts.master')

@section('title','Maniobras')

@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Maniobras' => '' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <ul id="filtros" class="nav nav-pills">
                    <li class="active"><a href data-filter="todos" data-toggle="tab">Todos</a></li>
                    <li><a href data-filter="finalizados" data-toggle="tab">Finalizados</a></li>
                    <li><a href data-filter="haciendo" data-toggle="tab">En proceso</a></li>
                    <li><a href data-filter="pendientes" data-toggle="tab">Pendientes</a></li>
                </ul>
            </div>
        </div>
        <template>
        <div id="oneDate" class="col-md-4 col-md-offset-2">
            <div class="input-group">
                <span class="input-group-addon">
                    <button type="button" id="view_range_date" title="Rango de fechas" data-toggle="tooltip" class="btn btn-simple btn-primary btn-just-icon">
                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                    </button>
                    <i class="fa fa-calendar "></i> Fecha
                </span>
                <input type="text" id="fecha" name="fecha" value="{{$data->format('j/m/Y')}}" class="form-control"  maxlength="10">
            </div>
        </div>    
        <div id="rangeDate" class="col-md-6 hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <button type="button" id="hide_range_date" title="Quitar rango de fechas" data-toggle="tooltip" class="btn btn-simple btn-primary btn-just-icon">
                                <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
                            </button>
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
                            <button type="button" id="source_date" title="Seleccionar fechas" class="btn btn-simple btn-primary btn-just-icon">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>                
        </div>
        </template>
        </div>
    </div>
   
        <card>
        <template>
            <div class="material-datatables">
                <table id="servicios" class="table table-no-bordered " cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Turno</th>
                            <th>Servicio</th>
                            <th>Nombre del cliente</th>
                            <th>Supervisor</th>
                            <th>Estatus</th>
                            <th><span class="visible-xs">Opciones</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Turno</th>
                            <th>Servicio</th>
                            <th>Cliente</th>
                            <th>Supervisor</th>
                            <th>Estatus</th>
                            <th>&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </template>
        </card>
       
       @include('layouts.partials.servicio-status-help')
        
</div>

@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    $().ready(function(){
        
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
            
            table.ajax.url( "/API/coordinacion/"+date  ).load();
            
        });
        let table = $('#servicios').DataTable( {
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
            ajax: "/API/coordinacion/",
            columns:[
                { 
                    data : "turno",
                    render : function(data, type, row){
                        return `
                            <span class="text-center yellow accent-1" style="display:block; font-size:5.2em;">`+data+`</span>
                        `;
                    }
                },
                { 
                    data : "servicio.tipo",
                    render :function(data,type,row){
                        return `
                            <p class="${data} letter-icon text-center" title="${data}" data-toggle="tooltip">${data.substring(0,1)}</p>
                        `;
                       
                    }
                },
                { 
                    data : "servicio.cliente.nombre",
                    render : function(data, type, row){
                        return `
                            <small class="text-muted">
                              <i class="fa fa-calendar-o" aria-hidden="true"></i> ${row.servicio.date_humans} - No. de servicio ${row.servicio.numero_servicio} 
                            </small> 
                            <h4 class="text-uppercase text-primary">${data}</h4>
                        `;
                    }     
                },
                {
                    data : null,
                    render : function(data, type, row){
                       
                        if( data.supervisor_id ){
                            if(data.supervisor_id == {{ auth()->user()->id }}){
                                return `<h6 class="text-center"><b>${data.supervisor.nombre}</b></h6>`;
                            }else{
                                return `<h6 class="text-center">${data.supervisor.nombre}</h6>`;
                            }
                            
                        }
                        else{
                            return '<h6 class="text-center text-danger">No asignado</h6>';
                        }
                    }
                },
                { 
                    data : "status",
                    render : function(data, type, row){
                        switch (data) {
                            case "PARA ASIGNAR": case "Para Asignar": case "para asignar":
                                return '<span class="label label-default '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-clock-o" aria-hidden="true"></i> '+data+'</span>'    
                            
                            case "ASIGNADO": case "Asignado": case "asignado":
                                return '<span class="label label-default '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-user-o" aria-hidden="true"></i> '+data+'</span>'    

                            case "EN PROCESO": case "En proceso": case "en proceso":
                                return '<span class="label label-info '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-play" aria-hidden="true"></i> '+data+'</span>'    
                                
                            case "EN PAUSA": case "En pausa": case "en pasua":
                                return '<span class="label label-warning '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-pause" aria-hidden="true"></i> '+data+'</span>'    
                                
                            case "FINALIZADO": case "Finalizado": case "finalizado":
                                return '<span class="label label-success '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-check" aria-hidden="true"></i> '+data+'</span>'    
                                
                            case "CANCELADO": case "Cancelado": case "cancelado":
                                return '<span class="label label-danger '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-ban" aria-hidden="true"></i> '+data+'</span>'    
                                
                       }
                    }
                },
                {
                    orderable: false,
                    data :null,
                    render : function(data, type, row){
                        if(row.supervisor_id == {{ auth()->user()->id }} ){
                            return `
                                <a href="/maniobras/${data.id}" class="btn btn-primary btn-round btn-just-icon">
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            `;
                        }else{
                            return `
                                <button type="button" class="btn btn-default btn-round btn-just-icon" disabled>
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </button>
                            `;
                        }
                    }
                }
                
                
            ]
        } );

        $.fn.dataTable.ext.errMode = 'throw';

        $("#filtros").on('click','a',function(){
            switch ($(this).data("filter")) {
                case 'finalizados':
                        table.columns(4).search("Finalizado").draw();     
                    break;
                case 'haciendo':
                        table.columns(4).search("EN PROCESO").draw();     
                    break;
                case 'pendientes':
                        table.columns(4).search("PARA ASIGNAR|EN PAUSA", true, false, true).draw();     
                    break;
                default:
                        table.columns(4).search("").draw();     
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
                console.log('date');
                console.log(date);
                table.ajax.url( "/API/coordinacion/"+date ).load();
            }
        });

        Echo.channel('maniobra-channel')
        .listen('ManiobraInicio', function(data)  {
            if( {{ auth()->user()->id }} == data.maniobra.receptor_id )
            {
                table.ajax.reload();
            }
        });  

        $('[data-toggle="tooltip"]').tooltip(); 
        

    });
</script>
@endpush

