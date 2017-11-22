@extends('pages.coordinacion.master')

@section('content-page')
   <h2 class="title">Transportes</h2>
    @foreach($servicio->servicio->transportes as $datos)
            @component('components.servicios.show.transportes',[
                'data' => $datos
            ])
            @endcomponent() 
        @endforeach()
        
@endsection
