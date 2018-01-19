@extends('pages.coordinacion.master')

@section('content-page')
   
        <h2 class="title">Documentos</h2>
    
        @component('components.servicios.show.archivos',['data'  =>  $servicio->servicio->archivos])
        @endcomponent()
        
    

        
@endsection
