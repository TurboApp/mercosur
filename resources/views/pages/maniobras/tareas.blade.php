@extends('layouts.master')

@section('title','Maniobra')

@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Maniobras' => 'maniobras', 'Maniobra x'=>'' ],
    ])
    @endcomponent()
@endsection

@section('nav-top')
    
@endsection

@section('content')
    <maniobra-tareas :maniobra-id="{{$coordinacion->id}}"></maniobra-tareas>
@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    
</script>
@endpush

