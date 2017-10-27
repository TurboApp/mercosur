@extends('layouts.master')

@section('title','Inicio')

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio'],
    ])
    @endcomponent()
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{$resumen}}
        </div>
    </div>
@endsection


@push('scripts')
    <script>
    </script>
@endpush