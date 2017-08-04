@extends('layouts.master')
@section('title','Clientes')
@section('nav-top')
<form class="navbar-form navbar-right" method="GET" action="/clientes/busqueda/" role="search">
    <div class="form-group form-search is-empty">
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="blue">
                <i class="material-icons">group</i>
            </div><!-- ./cards header -->
            <h4 class="card-title">Todos los clientes</h4>
            <div class="card-content">
                 @if(!count($clientes))
                <h2 class="text-center text-muted">No hay datos que mostrar</h2>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>RFC</th>
                                <th>Telèfono</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($clientes as  $index => $cliente)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ ( $cliente->rfc !== 'null' ) ? $cliente->rfc : '' }}</td>
                                <td>{{ ( $cliente->telefono !== 'null' ) ? $cliente->telefono : '' }}</td>
                                <td>{{ ( $cliente->celular !== 'null' ) ? $cliente->celular : '' }}</td>
                                <td>{{ ( $cliente->email !== 'null' ) ? $cliente->email : '' }}</td>
                                
                                <td class="td-actions text-right">
                                    <a href="/clientes/{{ $cliente->id }}" rel="tooltip" class="btn btn-info" data-original-title="info" title="Información">
                                       <i class="material-icons">insert_drive_file</i>
                                    </a>
                                    <a href="/clientes/{{ $cliente->id }}/editar" rel="tooltip" class="btn btn-primary" data-original-title="" title="Editar">
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
            <div class="card-footer text-center">
                {{ $clientes->links() }}
            </div>
            
        </div><!-- ./card -->
       
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')
    @include('layouts.partials.notify')
@endpush