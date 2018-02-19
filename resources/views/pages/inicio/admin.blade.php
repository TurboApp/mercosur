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
            
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="primary">
                    <i class="material-icons">group</i>
                </div>
                <div class="card-content">
                    <p class="category">Clientes</p>
                    <h3 class="card-title">{{ $resumen->totalClientes }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="/clientes/nuevo">
                            <i class="fa fa-plus" aria-hidden="true"></i>  Agregar nuevo cliente
                        </a>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="primary">
                    <i class="fa fa-id-card-o" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <p class="category">Agentes</p>
                    <h3 class="card-title">{{ $resumen->totalAgentes }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="/agentes/nuevo">
                            <i class="fa fa-id-card-o" aria-hidden="true"></i>  Agregar nuevo agente
                        </a>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="primary">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <p class="category">Transportes</p>
                    <h3 class="card-title">{{ $resumen->totalTransportes }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="/transportes/nuevo">
                            <i class="fa fa-truck" aria-hidden="true"></i>  Agregar nuevo transporte
                        </a>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="primary">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="card-content">
                    <p class="category">Usuarios</p>
                    <h3 class="card-title">{{ $resumen->totalUsuarios }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="/usuarios/nuevo">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>  Agregar nuevo usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>        

    </div>
    <div class="row">
            <div class="col-md-3 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header descarga" data-background-color="orange">
                                <i class="material-icons">arrow_downward</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Descargas</p>
                            <h3 class="card-title">{{ $resumen->descargasTotal }}</h3>
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
                            <h3 class="card-title">{{ $resumen->cargasTotal }}</h3>
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
                            <h3 class="card-title">{{  $resumen->serviciosTotal }}</h3>
                        </div>
                        
                    </div>
                </div>   
    </div>
@endsection


@push('scripts')
    <script>
    </script>
@endpush