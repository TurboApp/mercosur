@extends('layouts.master')
@section('title', $servicio->servicio->tipo .'. Servicio No. '. $servicio->servicio->numero_servicio )
@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Coordinación' => 'coordinacion', $servicio->servicio->tipo .'. Servicio No. '. $servicio->servicio->numero_servicio => '' ],
    ])
    @endcomponent()
@endsection
@section('nav-top')

@endsection
@section('content')
    
    <template>
        <panel-coordinacion :id="{{$servicio->id}}" ></panel-coordinacion>
    </template>
        
@endsection
@push('scripts')

    @include('layouts.partials.errors')
    
@endpush