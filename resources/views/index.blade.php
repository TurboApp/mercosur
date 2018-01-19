
@extends('layouts.master')
@section('title','Inicio')
@section('breadcrump')

   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'rutainicio', 'pagina' => 'ruta-pagina', 'Subpagina' => 'ruta-subpagina'],
    ])
    @endcomponent()

@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <p class="lead">Página en construcción</p>
        
    </div>

</div>
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        
    </div>
</div>

@endsection


@push('scripts')
@endpush