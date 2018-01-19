@extends('pages.coordinacion.master')

@section('content-page')
   
   <h2 class="title">Datos generales</h2>
   
    @component('components.servicios.show.datosgenerales',[
            'data'  =>  $servicio->servicio
        ])
    @endcomponent()

        
@endsection
