@extends('layouts.master')
@section('title','Nueva orden de servicio')
@section('nav-top')
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
            <h2>{{ $data['tipo'] }}</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right form-group">
                {{ ucfirst( $data["hoy"]->format('l j \\d\\e F \\d\\e Y') ) }}
                <p class="lead text-muted">Número de servicio {{$data["numero_servicio"]}}</p>
            </div>
        </div>
    </div>

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
        
            @component('components.servicios.create.archivos')
            @endcomponent()
            
            @component('components.servicios.show.archivos',['data'  =>  $servicio->archivosDescarga])
            @endcomponent()

        @else

            @component('components.servicios.create.archivos')
            @endcomponent()

        @endif
        
        
        {!! Form::submit('Crear orden de sercvicio', array('class'=>'btn btn-primary')) !!}
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