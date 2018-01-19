@extends('pages.maniobra.master')

@section('content-page')
   
   
    @component('components.servicios.show.datosgenerales',[
            'data'  =>  $servicio->servicio
        ])
    @endcomponent()

        
@endsection
