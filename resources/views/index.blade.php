
@extends('layouts.master')
@section('title','Prueba')
@section('nav-top')
<form class="navbar-form navbar-right" role="search">
    <div class="form-group form-search is-empty">
        <input type="text" class="form-control" placeholder="Buscar">
        <span class="material-input"></span>
    </div>
    <button type="submit" class="btn btn-white btn-round btn-just-icon">
        <i class="material-icons">search</i>
        <div class="ripple-container"></div>
    </button>
</form>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <p class="lead">Este es el contenido de la pagina</p>
    </div>

</div>
@endsection


@push('scripts')
<script>
    console.log('Hola mundo');    
</script>
@endpush