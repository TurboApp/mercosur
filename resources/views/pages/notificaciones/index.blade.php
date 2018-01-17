@extends('layouts.master')
@section('title','Notificaciones')
@section('nav-top')
    
@endsection

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Notificaciones' => '' ],
    ])
    @endcomponent()
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        {{--  {{$notificaciones}}  --}}
        <notificaciones-app></notificaciones-app>
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')
    @include('layouts.partials.notify')
@endpush
