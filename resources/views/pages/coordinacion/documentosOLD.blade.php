@extends('pages.coordinacion.master')

@section('content-page')
   
        <h2 class="title">Documentos</h2>
        
        @component('components.servicios.show.documentos',['data' => $servicio->servicio->documentos ])
        @endcomponent()
        
            
        
    

        
@endsection
