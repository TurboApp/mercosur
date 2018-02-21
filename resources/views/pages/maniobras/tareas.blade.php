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
    @if ($coordinacion->servicio->tipo=="Descarga" && $coordinacion->status=="Finalizado")
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <a href="/pdf/{{$coordinacion->servicio->id}}/tarjeta" target="_blank"><button type="button" class="btn btn-primary btn-lg btn-block white-text" data-toggle="tooltip" data-placement="top" title="tarjeta"><i class="fa fa-print fa-lg" aria-hidden="true"></i> Imprimir</button></a>
        </div>
    </div>
    @endif
    
    <maniobra-tareas :datos="{{$coordinacion}}" :tareas="{{$tareas}}">
    </maniobra-tareas>
   
@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    
</script>
@endpush

