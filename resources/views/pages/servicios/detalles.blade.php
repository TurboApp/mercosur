@extends('layouts.master')
@section('title', $coordinacion->servicio->tipo .'. Servicio No. '. $coordinacion->servicio->numero_servicio )
@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => 'servicios', $coordinacion->servicio->tipo .'. Servicio No. '. $coordinacion->servicio->numero_servicio => '' ],
    ])
    @endcomponent()
@endsection
@section('nav-top')

@endsection
@section('content')
    <template>
        <panel-coordinacion :datos="{{$coordinacion}}" ></panel-coordinacion>
    </template>
        
@endsection
@push('scripts')

    @include('layouts.partials.errors')
    
@endpush