@extends('layouts.master')
@section('title','Equipos')
@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Herramientas' => 'inicio', 'Equipos' => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <p >Total de equipos: {{$equipos->count()}}</p>  
            </div>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary btn-round motal-create" data-toggle="modal" data-target="#equipoInfoModal">Agregar</button>
        </div>
    </div>
    <div class="row">
        @forelse($equipos as $equipo)
            <div class="col-md-4">
                <card>
                    <div class="info text-center">
                        <div class="icon icon-danger">
                            <span class="fa-stack fa-2x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="description text-center">
                            <h4 class="info-title">{{$equipo->nombre}}</h4>
                            <p>{{$equipo->descripcion}}</p>
                            <h6><strong>{{$equipo->miembros}} @if($equipo->miembros==1) Miembro @else Miembros @endif </strong></h6>
                            <a href="#editar" class="btn btn-primary btn-simple btn-sm modal-edit" data-equipo="{{$equipo->id}}" data-toggle="modal" data-target="#equipoInfoModal">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                Editar
                            </a>
                            <a href="/herramientas/equipos/detalles/{{$equipo->id}}" class="btn btn-success btn-simple btn-sm">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                Detalles
                            </a>
                        </div>
                    </div>
                </card>
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
    @include('layouts.partials.errors')
    @include('layouts.partials.notify')
    <script>
        $(document).on("click",".motal-create",function(){
            $('#idTeam').remove();
            $('#modal_equipo_nombre').val('');
            $('#modal_equipo_descripcion').val('');
        });
        $(document).on("click",".modal-edit",function(){
            $('#idTeam').remove();
            $('#modal_equipo_nombre').val('');
            $('#modal_equipo_descripcion').val('');
            if($(this).data('equipo')){
                $('#formEquipo').attr('action', '/herramientas/equipos/update');
                let id = $(this).data('equipo');
                axios.get('/herramientas/equipos/info/'+id)
                .then(function(response){  
                    let data=response.data;
                    $('#modal_equipo_nombre').val(data.nombre);
                    $('#modal_equipo_descripcion').val(data.descripcion);
                    $('#formEquipo .modal-body').append('<input type="hidden" id="idTeam" name="id" value="'+data.id+'"/>');
                });
            }
        });
    </script>
@endpush
