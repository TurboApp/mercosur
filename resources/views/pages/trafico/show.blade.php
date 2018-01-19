@extends('layouts.master')

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => 'servicios',  $servicio->tipo . ': Número de servicio '. $servicio->numero_servicio => '' ],
    ])
    @endcomponent()
@endsection

@section('title', $servicio->tipo . ': Número de servicio '. $servicio->numero_servicio)


@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/trafico/nuevo"  title="Nuevo servicio">
                <i class="material-icons">add</i>
                <p class="hidden-lg hidden-md">Nuevo servicio</p>
            </a>
        </li>
        <li>
            <a href="/trafico" title="Ir a servicios">
                <i class="material-icons">arrow_upward</i>
                <p class="hidden-lg hidden-md">Ir a servicios</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
@endsection
@section('content')

<div class="container-fluid">
    <div class="form-horizontal">
    
        @component('components.servicios.show.datosgenerales',[
            'data'  =>  $servicio
        ])
        @endcomponent()
        
        @foreach($servicio->transportes as $datos)
            @component('components.servicios.show.transportes',[
                'data' => $datos
            ])
            @endcomponent() 
        @endforeach()
            
        

        @if ( $servicio->tipo === "Carga" )
        
            @component('components.servicios.show.documentos',['data' => $servicio->documentosCarga ])
            @endcomponent()
        
            @component('components.servicios.show.archivos',['data'  =>  $servicio->archivosCarga])
            @endcomponent()
        
        @else

            @component('components.servicios.show.documentos',['data' => $servicio->documentosDescarga ])
            @endcomponent()

            @component('components.servicios.show.archivos',['data'  =>  $servicio->archivosDescarga])
            @endcomponent()
        
        @endif()

    </div>
    <div class="row">
        <div class="col-md-12 text-right">
                Fecha de creación: {{$servicio->created_at->format('d/m/Y h:i:s')}}<br>
                Creado por ...
        </div>
    </div>
</div>

@endsection
@push('scripts')
    @include('layouts.partials.errors')
@endpush
