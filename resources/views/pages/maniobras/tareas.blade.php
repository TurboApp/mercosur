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
    <maniobra-descarga :maniobra-id="{{$coordinacion->id}}"></maniobra-descarga>
@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    
</script>
@endpush

