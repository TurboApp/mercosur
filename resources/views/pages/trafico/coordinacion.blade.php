@extends('layouts.master')
@section('title','Coordinación')

@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Coordinación' => '' ],
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
                    <button type="button" id="view_range_date" title="Agregar rango de fechas" class="btn btn-simple btn-default btn-just-icon"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></button>
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
                            <button type="button" id="hide_range_date" title="Quitar rango de fechas" class="btn btn-simple btn-default btn-just-icon"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i></button>
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
        <card>
        <template>
            <div class="material-datatables">
                <table id="servicios" class="table table-no-bordered " cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Turno</th>
                            <th>Servicio</th>
                            <th>Cliente</th>
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
            table.ajax.url( "/API/coordinacion/"+date ).load();
            
        });
        let table = $('#servicios').DataTable( {
            order: [],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            ajax: "/API/coordinacion",
            columns:[
                { 
                    data : "turno",
                    render : function(data, type, row){
                        return `
                            <span class="text-center yellow accent-2" style="display:block; font-size:5.2em;">`+data+`</span>
                        `;
                    }
                },
                { 
                    data : "servicio.tipo",
                    render :function(data,type,row){
                        return  `
                        <figure class="`+data+` img-rounded" style="padding:5px;max-width:200px;margin:0 auto;">
                            <img src="/img/servicios-iconos/`+data.toLowerCase()+`-icon-on.png" alt="`+ data +`">
                            <figcaption style="margin-top:1em;"><p class="text-center text-uppercase">`+data+`</p></figcaption>
                       </figure>
                        `;
                    }
                },
                { 
                    data : "servicio.cliente.nombre",
                    render : function(data, type, row){
                        return `
                            <small class="text-muted">
                              <i class="fa fa-calendar-o" aria-hidden="true"></i> `+ row.servicio.date_humans +` - No. de servicio `+row.servicio.numero_servicio+` 
                            </small> 
                            <h4 class="text-uppercase text-primary">`+data+`</h4>;
                        `;
                    }     
                },
                {
                    data : null,
                    render : function(data, type, row){
                       
                        if( data.supervisor_id ){
                            return '<p class="text-center"><b>'+data.supervisor.nombre+'</b></p>';
                            
                        }
                        else{
                            return '<h6 class="text-center text-danger">No asignado</h6>';
                        }
                    }
                },
                { 
                    data : "servicio.status",
                    render : function(data, type, row){
                        
                        switch (data) {
                            case "PARA ASIGNAR": case "Para asignar": case "para asignar":
                                return '<span class="label label-default '+ data.replace(" ", "-").toLowerCase() +'"><i class="fa fa-clock-o" aria-hidden="true"></i> '+data+'</span>'    

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
                        if(data.supervicor_id !== 'Null'){
                            return `
                                <a href="/trafico/maniobra/`+data.id+`/detalles" class="btn btn-info btn-simple btn-icon">
                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                </a>
                            `;
                        }else{
                            return `
                                <a href="/trafico/maniobra/`+data.id+`/detalles" class="btn btn-primary btn-simple btn-icon">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                </a>
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

        $("#view_range_date,#hide_range_date").mouseover(function(){
            $(this).removeClass("btn-default");
            $(this).addClass("btn-primary");
        });
        $("#view_range_date,#hide_range_date").mouseout(function(){
            $(this).removeClass("btn-primary");
            $(this).addClass("btn-default");
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
            let fechaInicio=moment(inicio.val(), 'DD/MM/YYYY', true);
            let fechaFinal=moment(final.val(), 'DD/MM/YYYY', true);
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
                table.ajax.url( "/API/coordinacion/"+date).load();
            }
        });
    });
</script>
@endpush

