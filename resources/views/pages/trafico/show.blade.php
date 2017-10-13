@extends('layouts.master')
@section('title','Orden de servicio')
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
        <div class="col-md-6">
            <h2>{{$servicio->tipo}}</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right form-group">
                <p class="lead text-muted">Número de servicio {{$servicio->numero_servicio}}</p>
            </div>
        </div>
    </div>
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
