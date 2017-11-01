@extends('layouts.master')

@section('title', 'Descarga Nuevo servicio' )

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => 'servicios',  'Nuevo servicio' => 'seleccionarNuevoServicio', ':  Número de servicio ' => '' ],
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

<div class="col-sm-12">
    <!--      Wizard container        -->
    <div class="wizard-container">
        <div id="nuevoServicio" class="card wizard-card"  >
            {!! Form::open(array('url' => '/servicio/store', 'method'=>'post', 'id'=>'formServicioNuevo', 'class'=>'form-horizontal','files'=>true, 'autocomplete'=>'off')) !!}
                {!! Form::hidden('tipo', $data['tipo']) !!}    
                <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                <div class="wizard-header grey lighten-3 ">
                    <h3 class="wizard-title">
                        Nuevo servicio Descarga
                    </h3>
                    <h5>Completa la siguiente información para crear el nuevo servicio.</h5>
                </div>
                <div class="wizard-navigation">
                    <ul>
                        <li>
                            <a href="#generales" data-toggle="tab">Datos Generales</a>
                        </li>
                        <li>
                            <a href="#transportes" data-toggle="tab">Transportes</a>
                        </li>
                        <li>
                            <a href="#documentos" data-toggle="tab">Documentos</a>
                        </li>
                        <li>
                            <a href="#archivos" data-toggle="tab">Archivos</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane" id="generales">
                        <div class="row">
                            @component('components.servicios.create.datosGenerales',[
                                'data' => $data
                            ])
                            @endcomponent()
                        </div>
                    </div>
                    <div class="tab-pane" id="transportes">
                            {{--  <h4 class="info-text">Introdusca los datos del transporte (with validation)</h4>      --}}
                            @component('components.servicios.create.transporte', [
                                'tipo' => 'destino'
                            ])
                            @endcomponent
                        
                        
                        {{--  <div class="row">
                            @component('components.servicios.create.transporte',[
                                'type' => 'Descarga'
                            ])
                            @endcomponent
                        </div>  --}}
                    </div>
                    <div class="tab-pane" id="documentos">
                         <add-document ></add-document>
                    </div>
                    <div class="tab-pane" id="archivos">
                        Archivos
                    </div>
                </div>
                <div class="wizard-footer">
                    <div class="pull-right">
                        <button type='button' class='btn btn-next btn-fill btn-primary btn-just-icon btn-round btn-wd' title="Siguiente" name='next' /><i class="material-icons">keyboard_arrow_right</i></button>
                        <button type='button' class='btn btn-finish btn-fill btn-success btn-just-icon btn-round btn-wd' name='finish' title="Finalizar" /><i class="material-icons">check</i></button>
                    </div>
                    <div class="pull-left">
                        <button type='button' class='btn btn-previous btn-fill btn-primary btn-just-icon btn-round btn-wd' title="Anterior" name='previous'/><i class="material-icons">keyboard_arrow_left</i></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- wizard container -->
</div>



@endsection
@push('scripts')
    @include('layouts.partials.errors')
    
    <script type="text/javascript">
    //$(document).ready(function(){
        //app.getMarcaVehiculo('.get-marca-vehiculo'); //sujerencia marca de vehiculo
        //app.getTipoVehiculo('.siggest-tipo-vehiculo');

    //}); 
    $(function() {
        
        
           
        $('.selectpicker').on('change', function () {
            $(this).valid();
            $(this).siblings( ".btn" ).removeClass('btn-danger');
            $(this).siblings( ".select-with-transition" ).removeClass('error_selectpicker');
            $(this).closest( ".form-group" ).removeClass('has-error');
        });
        // Code for the Validator
        var $validator = $('.wizard-card form').validate({
    		  

            errorPlacement: function(error, element) {
                $(element).closest('div.form-group').addClass('has-error');
                $(element).siblings( ".btn" ).addClass('btn-danger');
                $(element).siblings( ".select-with-transition" ).addClass('error_selectpicker');
             }
    	});

        // Wizard Initialization
      	$('.wizard-card').bootstrapWizard({
            'tabClass': 'nav nav-pills',
            'nextSelector': '.btn-next',
            'previousSelector': '.btn-previous',

            onNext: function(tab, navigation, index) {
            	var $valid = $('.wizard-card form').valid();
            	if(!$valid) {
            		$validator.focusInvalid();

            		return false;
            	}
            },
            onInit : function(tab, navigation, index){

              //check number of tabs and fill the entire row
              var $total = navigation.find('li').length;
              $width = 100/$total;
              var $wizard = navigation.closest('.wizard-card');
               
              $display_width = $(document).width();

              if($display_width < 600 && $total > 3){
                  $width = 50;
              }

               navigation.find('li').css('width',$width + '%');
               $first_li = navigation.find('li:first-child a').html();
               $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
              
               $('.wizard-card .wizard-navigation').append($moving_div);
               refreshAnimation($wizard, index);
               $('.moving-tab').css('transition','transform 0s');
           },

            onTabClick : function(tab, navigation, index){
                var $valid = $('.wizard-card form').valid();

                if(!$valid){
                    return false;
                } else{
                    return true;
                }
            },

            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;

                var $wizard = navigation.closest('.wizard-card');

                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $($wizard).find('.btn-next').hide();
                    $($wizard).find('.btn-finish').show();
                } else {
                    $($wizard).find('.btn-next').show();
                    $($wizard).find('.btn-finish').hide();
                }

                button_text = navigation.find('li:nth-child(' + $current + ') a').html();

                setTimeout(function(){
                    $('.moving-tab').text(button_text);
                }, 150);

                refreshAnimation($wizard, index);
            }
      	});


        $('.set-full-height').css('height', 'auto');

          $(window).resize(function(){
            $('.wizard-card').each(function(){
                $wizard = $(this);
                index = $wizard.bootstrapWizard('currentIndex');
                refreshAnimation($wizard, index);

                $('.moving-tab').css({
                    'transition': 'transform 0s'
                });
            });
        });

        function refreshAnimation($wizard, index){
            total_steps = $wizard.find('.wizard-navigation li').length;
            
            move_distance = $wizard.width() / total_steps;
            step_width = move_distance;
            move_distance *= index;

            $current = index + 1;

            if($current == 1){
                move_distance -= 8;
            } else if($current == total_steps){
                move_distance += 8;
            }

            $wizard.find('.moving-tab').css('width', step_width);
            $('.moving-tab').css({
                'transform':'translate3d(' + move_distance + 'px, 0, 0)',
                'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

            });  
        }

    });
    


       

    </script>
@endpush