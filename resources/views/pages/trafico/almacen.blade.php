@extends('layouts.master')
@section('title','Almacén')
@section('content')
<div class="container-fluido">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h2>Almacén</h2>
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
    
    <div class="row">
        <card>
        <template>
            <div class="material-datatables">
                <table id="almacen" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Documentos</th>
                            <th><span class="visible-xs">Detalles</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Documentos</th>
                            <th>&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </template>
        </card>
    </div>
</div>
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Información de almacen</h4>
      </div>
      <div class="modal-body">
          <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-4 label-on-left text-right">Numero de servicio</label>
                    <div class="col-md-8">
                        <span id="modal_num_servicio" class="form-control-static">9090</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 label-on-left text-right">Agente</label>
                    <div class="col-md-8">
                        <span id="modal_agente" class="form-control-static"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 label-on-left text-right">Cliente</label>
                    <div class="col-md-8">
                        <span id="modal_cliente" class="form-control-static"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 label-on-left text-right">Destino</label>
                    <div class="col-md-8">
                        <span id="modal_destino" class="form-control-static"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 label-on-left text-right">Fecha y hora</label>
                    <div class="col-md-8">
                        <span id="modal_fecha" class="form-control-static">12/05/2018 - 12:45 PM</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 label-on-left text-right">Documentos</label>
                    <div class="col-md-8">
                        <ul id="modal_documentos" class="list-unstyled form-control-static">
                            
                        </ul>
                    </div>
                </div>
          </div>
      </div>
      <div class="modal-footer">
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-simple" data-dismiss="modal">Cerrar</button>
                <a id="goToCarga" href="#" class="btn btn-primary" style="margin:0;">Servicio de Carga</a>
            </div>
      </div>
    </div>
  </div>
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
            table.ajax.url( "/API/almacen/"+date ).load();
            
        });
        let table = $('#almacen').DataTable( {
            order: [],
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            ajax: "/API/almacen",
            columns :[
                { 
                    data : "cliente.nombre",
                    render: function(data, type, row){
                        
                        let cliente = data;
                        let destino = "DESTINO: " + row.destino + " | " + row.destino_pais;
                                                
                        if( data.length > 80 )
                        {
                            cliente = '<span title="' + data + '">' + data.substr( 0, 78 ) + '...</span>';
                        }
                        if( destino.length > 80 )
                        {
                            destino = '<span title="' + destino + '">' + destino.substr( 0, 78 ) + '...</span>'; 
                        }
                        return '<small>No. Servicio '+ row.numero_servicio +' </small><h4 class="text-uppercase text-primary">' + data + '</h4><small class="text-muted">' + destino + '</small>' ;
                        
                    },
                    
                },
                
                { 
                    data : "fecha",
                    
                },
                
                { 
                    data : "documentos_descarga",
                    render: "[<br> ].nombre",
                    orderable: false,
                    
                },
                {
                    orderable: false,
                    data: null,
                    render: function(data, type, row){
                       return '<button type="button" class="btn btn-primary btn-simple btn-icon open-modal" data-datos="'+data.id+'" data-toggle="modal" data-target="#modalInfo"><i class="fa fa-folder-o" aria-hidden="true"></i></button>';
                    },
                    
                }
                
            ]
        } );
       
        $(document).on("click",".open-modal",function(){
            let datos = $(this).data('datos');
            $('#modal_num_servicio').html("");
            $('#modal_agente').html("");
            $('#modal_cliente').html("");
            $('#modal_destino').html("");
            $('#modal_fecha').html("");
            $('#modal_documentos').html("");
            $('#goToCarga').attr("href","#");
            axios.get('/API/almacen/item/'+datos)
            .then(function(response){
                let data=response.data;
                console.log(data);
                $('#modal_num_servicio').text(data.numero_servicio);
                $('#modal_agente').text(data.agente.nombre+" ("+data.agente.nombre_corto+")");
                $('#modal_cliente').text(data.cliente.nombre);
                $('#modal_destino').text(data.destino +" - "+ data.destino_pais);
                $('#modal_fecha').text(data.fecha_recepcion + " - "+data.hora_recepcion);
                $.each(data.documentos_descarga, function(key,val){
                    console.log(val.status);
                    if(val.status == "1"){
                        $('#modal_documentos').append("<li>"+val.tipo_documento+"-"+val.documento+"</li>");
                    }else{
                        $('#modal_documentos').append("<li>"+val.tipo_documento+"-"+val.documento+" <span class=\"badge light-green accent-4\"><i class=\"fa fa-check\"></i> Cargado</span></li>");
                    }
                });
                $('#goToCarga').attr("href","/trafico/nuevo/servicio/Carga/"+datos);
            });
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
                console.log("La fecha inicial no debe ser mayor a la fecha final");
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
                table.ajax.url( "/API/almacen/"+date).load();
            }
        });


    });
</script>
@endpush
