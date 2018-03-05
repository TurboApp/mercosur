@extends('layouts.master')
@section('title', $coordinacion->servicio->tipo .'. Servicio No. '. $coordinacion->servicio->numero_servicio )
@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Coordinación' => 'coordinacion', $coordinacion->servicio->tipo .'. Servicio No. '. $coordinacion->servicio->numero_servicio => '' ],
    ])
    @endcomponent()
@endsection
@section('nav-top')

@endsection
@section('content')

    @if ( $coordinacion->coordinador_id === auth()->user()->id )
        <navs-supervisores :supervisores="{{$supervisores}}">

        </navs-supervisores>
    @endif
    <template>
    <panel-coordinacion 
        :datos = "{{$coordinacion}}" 
        :auth = "{{ $coordinacion->servicio->autor->equipo_id == auth()->user()->equipo_id && auth()->user()->perfil->perfil == 'coordinador'  ? 1 : 0 }}" 
        :auth-id = "{{ auth()->user()->id }}"
    ></panel-coordinacion>
    </template>
        
@endsection
@push('scripts')

    @include('layouts.partials.errors')
    
@endpush