@extends('layouts.master')
@section('title','Busqueda de Destinos')
@section('nav-top')
  <form class="navbar-form navbar-right" method="GET" action="/destinos/busqueda/" role="search">
    <div class="form-group form-search is-empty">
        <input type="text" class="form-control" name="s" placeholder="Buscar" value="{{$request->s}}">
        <span class="material-input"></span>
    </div>
    <button type="submit" class="btn btn-white btn-round btn-just-icon">
        <i class="material-icons">search</i>
        <div class="ripple-container"></div>
    </button>
</form>
@endsection
@section('content')
  <div class="flash-message">
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
          <div class="alert alert-{{ $msg }}">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <i class="material-icons">close</i>
              </button>
              {{ Session::get('alert-' . $msg) }}
          </div>
        @endif
      @endforeach
  </div> <!-- end .flash-message -->

  <div class="row">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-text" data-background-color="blue">
                 <h4 class="card-title"><i class="fa fa-search" aria-hidden="true"></i> Resultados de la busqueda.</h4>
                  <p class="category">
                     {{$request->s}}
                  </p>
              </div><!-- ./cards header -->
              <div class="card-content">
                  @if(!count($destinos))
                  <h2 class="text-center text-muted">No se encontraron resultados</h2>
                  @else
                  <div class="table-responsive">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th class="text-center">#</th>
                                  <th>Agente</th>
                                  <th>RFC</th>
                                  <th>Telèfono</th>
                                  <th>Celular</th>
                                  <th>Email</th>
                                  <th class="text-right">Acciones</th>
                              </tr>
                          </thead>
                          <tbody>
                               @foreach($destinos as  $index => $destino)
                              <tr>
                                  <td class="text-center">{{ $index + 1 }}</td>
                                  <td>{{ $destino->nombre }}</td>
                                  <td>{{ ( $destino->rfc !== 'null' ) ? $destino->rfc : '' }}</td>
                                  <td>{{ ( $destino->telefono !== 'null' ) ? $destino->telefono : '' }}</td>
                                  <td>{{ ( $destino->celular !== 'null' ) ? $destino->celular : '' }}</td>
                                  <td>{{ ( $destino->email !== 'null' ) ? $destino->email : '' }}</td>

                                  <td class="td-actions text-right">
                                      <a href="/destinos/{{ $destino->id }}" rel="tooltip" class="btn btn-info" data-original-title="info" title="Información">
                                         <i class="material-icons">insert_drive_file</i>
                                      </a>
                                      <a href="/destinos/{{ $destino->id }}/editar" rel="tooltip" class="btn btn-primary" data-original-title="" title="Editar">
                                          <i class="material-icons">edit</i>
                                      </a>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div><!-- ./table-responsive -->
                  @endif
              </div><!-- ./card-cotent -->
              @if(count($destinos))
              <div class="card-footer text-center">
                  {{ $destinos->links() }}
              </div>
              @endif

          </div><!-- ./card -->

      </div><!-- ./col-md-12 -->

  </div><!-- ./row -->
@endsection
