@extends('pages.maniobra.master')

@section('content-page')
   
   @if ( $servicio->tipo === "Carga" )
        
            @component('components.servicios.show.documentos',['data' => $servicio->servicio->documentosCarga ])
            @endcomponent()
        
            
        
    @else

            @component('components.servicios.show.documentos',['data' => $servicio->servicio->documentosDescarga ])
            @endcomponent()
        
    @endif()

        
@endsection
