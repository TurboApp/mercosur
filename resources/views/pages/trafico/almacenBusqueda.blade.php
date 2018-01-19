@extends('layouts.master')
@section('title','Almacen')
@section('nav-top')
<ul class="nav navbar-nav navbar-right">
  <li>
      <a href="{{ URL::previous() }}" rel="tooltip" data-placement="bottom" title="Ir atras">
          <i class="material-icons">arrow_back</i>
          <p class="hidden-lg hidden-md">Regresar</p>
      </a>
  </li>
  <li class="separator hidden-lg hidden-md"></li>
</ul>
<form class="navbar-form navbar-right" method="GET" action="/trafico/almacen/busqueda/" role="search">
  <div class="form-group form-search is-empty">
        <select name="by" class="form-control">
            <option val="name">Nombre</option>
            <option val="date">Fecha</option>
            <option val="doc">Documento</option>
        </select>
      <input type="text" class="form-control" name="s" placeholder="Buscar">
      <span class="material-input"></span>
  </div>
  <button type="submit" class="btn btn-white btn-round btn-just-icon">
      <i class="material-icons">search</i>
      <div class="ripple-container"></div>
  </button>
</form>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <h2>Almacén</h2>
        </div>
        <div class="col-md-6">
            <div class="text-right form-group">
                {{--{{$data['hoy']->format('l j \\d\\e F \\d\\e Y')}}--}}
            </div>
        </div>
    </div>
    
        
        <card  type="header-icon" icon="assignment" bg-color="blue">
        <template>
            <template slot="title">Seleccione el cliente</template>
            <div class="table-responsive">
                <table id="tableDescargas" class="table table-striped table-shopping">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha y hora</th>
                            <th>Documentos</th>
                            <th>Servicio</th>
                            <!-- <th>Ir a carga</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($almacen as $index => $servicio)
                        @if($servicio->documentos()->sum('status'))
                        <tr>
                            <td class="text-center"><p class="text-muted">{{ $index }}</p></td>
                            <td class="td-name">
                                <h4><a href="/trafico/nuevo/carga/{{$servicio->id}}">{{$servicio->cliente->nombre}}</a></h4>
                                <small><i class="fa fa-globe" aria-hidden="true"></i> Destino: {{$servicio->destino}} - {{$servicio->destino_pais}}</small>
                            </td>
                            <td>
                                <span style="display:block;">{{$servicio->fecha_recepcion}}</span>
                                <small style="display:block;">a las {{$servicio->hora_recepcion}}</small>

                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    
                                    @foreach($servicio->documentos as $documento)
                                        @if($documento->status === 0)
                                            <li><small><del> {{$documento->tipo_documento}} - {{$documento->documento}} </del></small></li>
                                        @else    
                                            <li><small> {{$documento->tipo_documento}} - {{$documento->documento}} </small></li>
                                        @endif    
                                    @endforeach
                                    
                                </ul>
                            </td>
                            <td><p class="lead text-center">{{$servicio->numero_servicio}}</p></td>
                            <!-- <td class="text-center">
                                <a href="/trafico/nuevo/carga/{{$servicio->id}}" class="btn btn-primary btn-just-icon btn-round">
                                    <i class="material-icons">open_in_new</i>
                                </a>
                            </td> -->
                        </tr>
                        @endif
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
               {{-- {{ $almacen->links() }} --}}
            </div>
        </template>
        </card>
       
</div>
@endsection
@push('scripts')
<script>
    
</script>
@endpush
