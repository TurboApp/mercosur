@extends('layouts.master')

@section('title', $coordinacion->servicio->tipo . '. Servicio No.' . $coordinacion->servicio->numero_servicio)

@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Maniobras' => 'maniobras', $coordinacion->servicio->tipo . '. Servicio No.' . $coordinacion->servicio->numero_servicio=>'' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    
@endsection

@section('content')
   
    @if ($coordinacion->servicio->tipo=="Descarga")
        <a href="/pdf/{{$coordinacion->servicio->id}}/tarjeta" target="_blank"><button class="btn transparent btn-just-icon btn-simple black-text " data-toggle="tooltip" data-placement="top" title="tarjeta"><i class="fa fa-print fa-lg" aria-hidden="true"></i></button></a>
    @endif
    
    <maniobra-tareas :datos="{{$coordinacion}}" :tareas="{{$tareas}}">
    </maniobra-tareas>
   
@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    
</script>
@endpush

