@extends('pages.maniobra.master')

@section('content-page')
   
    @foreach($servicio->servicio->transportes as $datos)
            @component('components.servicios.show.transportes',[
                'data' => $datos
            ])
            @endcomponent() 
        @endforeach()
        
@endsection
