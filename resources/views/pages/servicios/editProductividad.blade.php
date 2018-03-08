@extends('layouts.master')

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => 'servicios',  'Edición: '. $servicio->tipo => '' ],
    ])
    @endcomponent()
@endsection

@section('title', 'Edición: '.$servicio->tipo )


@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/servicios/nuevo"  title="Nuevo servicio">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Nuevo servicio</p>
            </a>
        </li>
        <li>
            <a href="/servicios" title="Ir a servicios">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a servicios</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h1 class="title">{{$servicio->tipo}}</h1>
        </div>
    </div>
    <div class="row">
        <card>
            <template>
                {!! Form::open(['url' => 'foo/bar', 'class'=>'form-horizontal']) !!}

                
                <div class="form-group">
                    <label class="col-md-2 control-label">Estatus</label> 
                    <div class="col-md-10">
                        {!! Form::select('estatus', 
                            [
                                'Cancelado' => 'Canceldo',
                                'Asignado' => 'Asignado',
                                'Para Asignar' => 'Para Asignar',
                                'En Proceso' => 'En Proceso',
                                'Finalizado' => 'Finalizado', 

                            ], $coordinacion->status, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Inicio de maniobra</label> 
                    <div class="col-md-10">
                        @if(!empty($coordinacion->inicio_maniobra))
                            {!! Form::datetimeLocal('inicio_maniobra', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$coordinacion->inicio_maniobra),['class' => 'form-control']) !!}
                        @else
                            {!! Form::datetimeLocal('inicio_maniobra', null,['class' => 'form-control']) !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Fin de maniobra</label> 
                    <div class="col-md-10">
                        @if(!empty($coordinacion->termino_maniobra))
                            {!! Form::datetimeLocal('termino_maniobra', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$coordinacion->termino_maniobra), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::datetimeLocal('termino_maniobra', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Duración</label> 
                    <div class="col-md-10">
                        <p id="maniobraDuracion" class="form-control-static">
                            
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Avance de maniobra</label> 
                    <div class="col-md-10">
                        {!! Form::select('estatus', 
                        [
                            '0' => '0% Recepción y revisión de ordenes', 
                            '1' => '5% Revisión de la unidad',
                            '2' => '10% Previa validación ',
                            '3' => '15% Selección y activación de la fuerza de tarea',
                            '4' => '20% Proceso de maniobra ',
                            '5' => '90% Validación ',
                            '6' => '95% Ciere de maniobra ',
                            '7' => '100% Finalizado ',
                        ], 'S', ['class' => 'form-control']) !!}
                    </div>
                </div>


                    
               
                {!! Form::close() !!}
            </template>
        </card>
    </div>
</div>


@endsection
@push('scripts')

    @include('layouts.partials.notify')

    @include('layouts.partials.errors')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script>
        
        @if(!empty($coordinacion->termino_maniobra))
            let inicio_maniobra = moment('{{$coordinacion->inicio_maniobra}}');
            let termino_maniobra = moment('{{$coordinacion->termino_maniobra}}');
            let diffTime = termino_maniobra.diff(inicio_maniobra);
            let duration = moment.duration(diffTime, 'milliseconds');
            if(duration.days()){
                $('#maniobraDuracion').text(duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds()); 
            }else{
                $('#maniobraDuracion').text( duration.hours() + ":" + duration.minutes() + ":" + duration.seconds() );
            }

        @endif
        
            
        
    </script>
@endpush
