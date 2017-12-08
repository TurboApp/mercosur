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
   
    <maniobra-tareas :datos="{{$coordinacion}}">
    </maniobra-tareas>
   
@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    
</script>
@endpush

