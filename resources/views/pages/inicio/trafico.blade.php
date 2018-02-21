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
            <h2 class="text-muted">Hoy <small><a href="/servicios/">ver servicios</a></small></h2>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header descarga" data-background-color="orange">
                        <i class="material-icons">arrow_downward</i>
                </div>
                <div class="card-content">
                    <p class="category">Descargas</p>
                    <h3 class="card-title">{{ $resumen->descargasToday }}</h3>
                </div>
                
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header carga" data-background-color="orange">
                    <i class="material-icons">arrow_upward</i>
                </div>
                <div class="card-content">
                    <p class="category">Cargas</p>
                    <h3 class="card-title">{{ $resumen->cargasToday }}</h3>
                </div>
                
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header trasbordo" data-background-color="orange">
                    <i class="material-icons">compare_arrows</i>
                </div>
                <div class="card-content">
                    <p class="category">Trasbordos</p>
                    <h3 class="card-title">{{ $resumen->trasbordosToday }}</h3>
                </div>
                
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="rose">
                    <i class="material-icons">done</i>
                </div>
                <div class="card-content">
                    <p class="category">Total</p>
                    <h3 class="card-title">{{  $resumen->totalToday }}</h3>
                </div>
                
            </div>
        </div>   
            
    </div>
    
@endsection


@push('scripts')
    <script>
    </script>
@endpush