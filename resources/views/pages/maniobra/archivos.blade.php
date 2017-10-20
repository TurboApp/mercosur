@extends('pages.maniobra.master')

@section('content-page')
   
    @if ( $servicio->tipo === "Carga" )
        
            @component('components.servicios.show.archivos',['data'  =>  $servicio->servicio->archivosCarga])
            @endcomponent()
        
    @else

            @component('components.servicios.show.archivos',['data'  =>  $servicio->servicio->archivosDescarga])
            @endcomponent()
        
    @endif()

        
@endsection
