@extends('layouts.master')
@section('title','Nueva orden de servicio')
@section('nav-top')
  <ul class="nav navbar-nav navbar-right">
  <li>
      <a href="{{ URL::previous() }}" rel="tooltip" data-placement="bottom" title="Ir atras">
          <i class="material-icons">arrow_back</i>
          <p class="hidden-lg hidden-md">Regresar</p>
      </a>
  </li>
  <li class="separator hidden-lg hidden-md"></li>
</ul>
<form class="navbar-form navbar-right" method="GET" action="/trafico/busqueda/" role="search">
  <div class="form-group form-search is-empty">
      <input type="text" class="form-control" name="s" placeholder="Buscar">
      <span class="material-input"></span>
  </div>
  <button type="submit" class="btn btn-white btn-round btn-just-icon">
      <i class="material-icons">search</i>
      <div class="ripple-container"></div>
  </button>
</form>
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <h2>Carga</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right form-group">
                <p class="lead text-muted">Número de servicio {{ $servicio->numero_servicio }}</p>
            </div>
        </div>
    </div>
    <div class='form-horizontal'>
    <card type="header-icon" icon="fa-info" bg-color="blue">
    <template>
        <template slot="title">Datos generales</template>
        
        <div class="row ">
            <div class="col-md-6 ">
                <div class="row">
                    <div class="form-group">                       
                        <div class="col-md-6">
                            <select id="agente_id" class="selectpicker" data-style="btn btn-primary btn-round" disabled>
                                <option  selected>{{$servicio->agente->nombre_corto}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" title="Fecha">
                                <i class="fa fa-calendar "></i> Fecha
                            </span>
                            <input type="text" value="{{$servicio->fecha_recepcion}}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i> Hora
                            </span>
                            <input type="text" value="{{ $servicio->hora_recepcion }}" class="form-control" disabled>
                        </div>
                    </div>
                </div><!-- ./form-horizontal  -->
            </div><!-- ./col -->
            
        </div><!-- ./row -->
        <hr style="border:0;">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="form-group">
                        <label for="cliente" class="col-md-2 control-label">Cliente</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $servicio->cliente->nombre }}" disabled>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">RFC</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $servicio->cliente->rfc }}" disabled>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- cliente input hidden -->
        

        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label for="destiinatario" class="col-md-2 control-label">Destinatario</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $servicio->destino }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">País</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $servicio->destino_pais }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /row-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group label-floating">
                    <label for="observaciones" class="control-label">Observaciones</label>
                    <textarea class="form-control" disabled>{{ $servicio->observaciones }}</textarea>
                </div>
            </div>
        </div>

    </template>
    </card>


    <card type="header-icon" icon="fa-truck" bg-color="blue">
    <template>
        <template slot="title">Transporte</template>
        <div class="row">
            <div class="col-md-12">  
                <div class="form-group">
                    <span class="twitter-typeahead">
                        <label for="lineaTransporte" class="control-label">Linea de transporte</label>
                        <input type="text" class="form-control" value="{{ $servicio->transportes[0]->transporte->nombre }}" disabled>
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">  
                <div class="form-group">
                    <label for="operadorUnidad" class="control-label">Nombre del operador</label>
                    <input type="text" class="form-control" value="{{ $servicio->transportes[0]->nombre_operador }}" disabled>   
                </div>
            </div>
            <div class="col-md-4">  
                <div class="form-group">
                    <label for="n_talon" class="control-label">No. de talon</label>
                    <input type="text" class="form-control" value="{{ $servicio->transportes[0]->talon_embarque }}" disabled>   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="marcaVehiculo" class="control-label">Marca del Vehiculo</label>
                    <input type="text" class="form-control" value="{{ $servicio->transportes[0]->marca_vehiculo }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="placasTractor" class="control-label">Placas del tractor</label>
                    <input type="text" class="form-control" value="{{ $servicio->transportes[0]->placas_tractor }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label class="control-label">Placas de la caja</label>
                    <input type="text" class="form-control" value="{{ $servicio->transportes[0]->placas_caja }}" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    <label  for="tipoUnidad" class="control-label">Tipo de unidad</label>
                    <input type="text" class="form-control siggest-tipo-vehiculo" value="{{ $servicio->transportes[0]->tipo_unidad }}" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Medida</label>
                    <select class="selectpicker" data-style="select-with-transition"  disabled>
                        <option selected>{{ $servicio->transportes[0]->medida_unidad }}</option> 
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ejes" class="control-label">No. Ejes</label>
                    <input type="number" class="form-control" value="{{ $servicio->transportes[0]->ejes }}" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="number" class="form-control" value="{{ $servicio->transportes[0]->cantidad }}" disabled>
                </div>
            </div>
        </div>
    </template>
    </card>

{{$servicio->documentos}}
    
    <card type="header-icon" icon="fa-file-text-o" bg-color="blue">
    <template>
        <template slot="title">Documentos</template>
        <div class="row">
            <div class="col-md-12">
                <table class="table table bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Documento</th>
                            <th>Descripción</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Documento</th>
                            <th>Descripción</th>
                            <th>Estatus</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($servicio->documentos as $index => $documento)
                            <tr @if(! $documento->status ) class="text-muted" @endif >
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if( $documento->status )
                                        {{ $documento->tipo_documento }} - {{ $documento->documento }}
                                    @else
                                        <del><em>{{ $documento->tipo_documento }} - {{ $documento->documento }}</em></del>
                                    @endif
                                </td>
                                <td>
                                    @if( $documento->status )
                                        {{ $documento->descripcion }}
                                    @else
                                        <del><em>{{ $documento->descripcion }}</em></del>
                                    @endif
                                </td>
                                <td>
                                    @if( $documento->status )
                                        Almacén
                                    @else
                                        <em>Cargado</em>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </template>
    </card> 
   {{-- 
    <card type="header-icon" icon="fa-paperclip" bg-color="blue">
    <template>
        <template slot="title">Archivos</template>
        <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Extensión</th>
                    <th>Peso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicio->archivos as $index => $archivo)
                    <tr>
                        <td>
                            {{$index + 1 }}
                        </td>
                        
                        <td>
                            {{$archivo->nombre}}
                        </td>
                        <td>

                           <p>
                           @if( $archivo->minetype === 'application/pdf' )
                                <i class="fa fa-file-pdf-o text-muted fa-lg" aria-hidden="true"></i>
                            @elseif( $archivo->minetype === 'application/vnd.ms-excel' )
                                <i class="fa fa-file-excel-o text-muted fa-lg" aria-hidden="true"></i>
                            @elseif( $archivo->minetype === 'image/gif' || $archivo->minetype === 'image/jpg' || $archivo->minetype === 'image/jpeg' ||  $archivo->minetype === 'image/png')
                                <i class="fa fa-file-image-o text-muted fa-lg" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-file-o text-muted fa-lg" aria-hidden="true"></i>
                            @endif
                           .{{$archivo->extension}}
                           </p>
                        
                        </td>
                        <td>
                                    {{$archivo->size}}
                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </template>
    </card>
--}}
    </div>
</div>

@endsection
@push('scripts')
    @include('layouts.partials.errors')
    <script type="text/javascript">

    $(function() {
        demo.initFormExtendedDatetimepickers();
        demo.getCountry('.paises'); //sugerencia paises
        demo.getMarcaVehiculo('.get-marca-vehiculo'); //sujerencia marca de vehiculo
        demo.getTipoVehiculo('.siggest-tipo-vehiculo');
        
        $('[data-toggle="popover"]').popover();

        /*
        *    Typeahead Busqueda para cliente, destino, lineas de transportes
        */
        
        //TYPEAHEAD DESTINO
        let busquedaDestino=$('.search_destinatario');
        let getDataDestino = new Bloodhound({
            remote: {
                url: '/find/destino?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataDestino.initialize();
        busquedaDestino.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'destino',
            source: getDataDestino.ttAdapter(),
            name: 'clientes',
            templates: {
        
                suggestion: function (data) {
                    return '<p>' + data.destino + '</p>';
                }
            }
        });
        //TYPEAHEAD TRANSPORTES
        let idtransporte=$('#idtransporte');
        let busquedaTransporte = $('#busqueda_transporte.search_transporte');
        let getDataTransportes = new Bloodhound({
            remote: {
                url: '/find/transporte?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        getDataTransportes.initialize();
        busquedaTransporte.typeahead({
            hint: true,
            highlight: true,
            limit:8,
        }, {
            display: 'nombre',
            source: getDataTransportes.ttAdapter(),
            name: 'transportes',
            templates: {
                empty:function(){
                    return '<h4 class="text-danger"> &nbsp;<i class="fa fa-exclamation-circle" aria-hidden="true"></i> La busqueda no obtuvo ningun resultado.</h4>';
                },
                suggestion: function (data) {
                    return '<p>' + data.nombre + ' ( '+ data.nombre_corto +' )' + '</p>';
                }
            }
        });
        let ltransporteSelected='';
        let ltransporte=function(eventObject, suggestionObject, suggestionDataset){
            ltransporteSelected=suggestionObject.nombre;
            idtransporte.val(suggestionObject.id);
            $('#busqueda_transporte').closest('div.form-group').removeClass('has-error');
        };
        busquedaTransporte.on('typeahead:selected', ltransporte);
        busquedaTransporte.on('typeahead:autocompleted', ltransporte);
        busquedaTransporte.on('typeahead:change', function($e,data){
            if(data !== ltransporteSelected){
                idtransporte.val('');
                $('#busqueda_transporte').closest('div.form-group').addClass('has-error');
            }
        });
            
        /*Termina typeahead*/   
 
        var validator = $('#formNuevoServicio').validate({
            errorPlacement: function(error, element) {
                $(element).closest('div.form-group').addClass('has-error');
                
            },
            submitHandler: function(form) {
                if(!$('#idtransporte').val()){
                    $.notify({
                        icon: "warning",
                        message: "Debes seleccionar una linea de trasnporte valida para continuar"

                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    $('#busqueda_transporte').closest('div.form-group').addClass('has-error');
                    return;
                }
                    
                /*let validDocs=0;
                $('input[name^="documento"]').each(function() {
                    if( !$(this).is(':checked') ){
                        validDocs+=1;
                    }
                });
                if(!validDocs){
                    $('input[name^="documento"]').each(function() {
                        $(element).closest('div.checkbox').addClass('has-error');
                    });
                    $.notify({
                        icon: "warning",
                        message: "No se ha seleccionado ningun documento"

                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    return ;
                }*/
                
                form.submit();
                
            }

        });
        

        

    });
    </script>
@endpush
