@extends('layouts.master')

@section('title', $data['tipo'])

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => 'servicios',  'Nuevo servicio' => 'seleccionarNuevoServicio', $data['tipo'] => '' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/trafico/nuevo"  title="Nuevo servicio">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Nuevo servicio</p>
            </a>
        </li>
        <li>
            <a href="/trafico/nuevo" title="Ir a nuevo servicio">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a nuevo servicio</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
@endsection

@section('content')
<div class="container-fluid">
    
        <p class="lead text-muted pull-right">Número de servicio {{$data["numero_servicio"]}}</p>
    {!! Form::open(array('url' => '/trafico/servicio', 'method'=>'post', 'id'=>'formNuevoServicio', 'class'=>'form-horizontal','files'=>true, 'autocomplete'=>'off')) !!}
        {!! Form::hidden('tipo', $data['tipo']) !!}        
        

        @component('components.servicios.create.datosGenerales',[
            'data' => $data,
            'servicio' => $servicio
        ])
        @endcomponent()
        
        @if($data['tipo'] === 'Trasbordo')
         
            @component('components.servicios.create.transporte',[
                'type' => 'Descarga'
            ])
            @endcomponent

            @component('components.servicios.create.transporte',[
                'type' => 'Carga'
            ])
            @endcomponent

        @else
            
            @component('components.servicios.create.transporte',[
                'type' => $data['tipo']
            ])
            @endcomponent

        @endif
     
        @component('components.servicios.create.documentos', 
            ['servicio' => $servicio ])
        @endcomponent()
        
        @if( $data['tipo'] === "Carga")
        
            @component('components.servicios.show.archivos',['data'  =>  $servicio->archivosDescarga])
            @endcomponent()
            
            @component('components.servicios.create.archivos')
            @endcomponent()
            

        @else

            @component('components.servicios.create.archivos')
            @endcomponent()

        @endif
        
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {!! Form::submit('Crear orden de sercvicio', array('class'=>'btn btn-primary btn-lg btn-block')) !!}
            </div>
        </div>
    {!! Form::close() !!}

</div>

@endsection
@push('scripts')
    @include('layouts.partials.errors')
    <script type="text/javascript">
    $(function() {
        app.getMarcaVehiculo('.get-marca-vehiculo'); //sujerencia marca de vehiculo
        app.getTipoVehiculo('.siggest-tipo-vehiculo');
        
        var validator = $('#formNuevoServicio').validate({
            errorPlacement: function(error, element) {
                $(element).closest('div.form-group').addClass('has-error');
                $(element).siblings( ".btn" ).addClass('btn-danger');
                $(element).siblings( ".select-with-transition" ).addClass('error_selectpicker');
            },
            submitHandler: function(form) {
                {{--  if(!$('#idcliente').val()){
                    $.notify({
                        icon: "warning",
                        message: "Debes seleccionar un cliente valido para continuar"
                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    $('#busqueda_cliente').closest('div.form-group').addClass('has-error');
                    return;
                }
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
                    
                let validDocs=0;
                $('select[name^="documento"],input[name^="documento"]').each(function() {
                    if($(this).val()=='' && $(this).prop('required')){
                        $(this).closest('div.card-collapse').addClass("has-error");
                        validDocs+=1;
                    }
                });
                if(validDocs>1){
                    $.notify({
                        icon: "warning",
                        message: "Algunos documentos no se registraron correctamente"

                    },{
                        type: 'warning',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                    return ;
                }   --}}
                
                form.submit();
                
            }

        });
        $('.selectpicker').on('change', function () {
            $(this).valid();
            $(this).siblings( ".btn" ).removeClass('btn-danger');
            $(this).siblings( ".select-with-transition" ).removeClass('error_selectpicker');
            $(this).closest( ".form-group" ).removeClass('has-error');
        });

    });
    </script>
@endpush