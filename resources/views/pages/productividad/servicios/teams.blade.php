@extends('layouts.master')

@section('title','Servicios')

@section('breadcrump')
    @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Servicios' => '' ],
    ])
    @endcomponent()
@endsection


@section('content')
    <div class="row">
        @forelse($equipos as $equipo)
            <div class="col-md-4">
                <div class="card">
                    <div class="info card-content text-center">
                        <div class="icon icon-danger">
                            <span class="fa-stack fa-2x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="description text-center">
                            <h4 class="info-title">{{$equipo->nombre}}</h4>
                            {{$equipo->descripcion}}
                        </div>
                    </div>
                    <div class=" text-center">
                        <div class="col-md-4">
                            <i class="material-icons">arrow_downward</i>
                            <h4 class="title">56</h4>
                            <small class="text-muted text-truncate">Descargas</small>
                        </div>
                        <div class="col-md-4">
                            <i class="material-icons">arrow_upward</i>
                            <h4 class="title">56</h4>
                            <small class="text-muted text-truncate">Cargas</small>
                        </div>
                        <div class="col-md-4">
                            <i class="material-icons">compare_arrows</i>
                            <h4 class="title">56</h4>
                            <small class="text-muted text-truncate">Descargas</small>
                        </div>
                        <div class="row" >
                            <div class="col-md-12">
                                <a href="#" class="btn btn-block btn-primary" style="margin-bottom:0;">
                                    Servicios
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @empty
            <p class="lead text-muted text-center">No hay equipos</p>
        @endforelse
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            {{ $equipos->links() }}  
        </div>
    </div>
    {{-- modal --}}
      <div class="modal fade" id="equipoInfoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form id="formEquipo" class="" action="/herramientas/equipos/nuevo" method="post">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
                        <h4 class="modal-title" id="myModalLabel">Nuevo Equipo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-content">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label">Nombre del equipo</label>
                                    <input type="text" id="modal_equipo_nombre" name="nombre" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Descripción</label>
                                    <textarea name="descripcion" id="modal_equipo_descripcion" class="form-control"></textarea>
                                </div>
                        {{--  <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="text-align:left;">Color</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" value="" placeholder="Seleccione" id="colorpicker" readonly>
                            </div>
                        </div>  --}}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-simple btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@push('scripts')
@include('layouts.partials.notify')
<script>
    
        
</script>
@endpush

