@extends('layouts.master')
@section('title','Agentes')
@section('nav-top')
<form class="navbar-form navbar-right" method="GET" action="/agentes/busqueda/" role="search">
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
                <!--<i class="material-icons">group</i>-->
                <i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i>
            </div><!-- ./cards header -->
            <div class="card-content">
                <h4 class="card-title">Todos los agentes</h4>
                 @if(!count($agentes))
                <h2 class="text-center text-muted">No hay datos que mostrar</h2>
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
                             @foreach($agentes as  $index => $agente)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $agente->nombre }}</td>
                                <td>{{ ( $agente->rfc !== 'null' ) ? $agente->rfc : '' }}</td>
                                <td>{{ ( $agente->telefono !== 'null' ) ? $agente->telefono : '' }}</td>
                                <td>{{ ( $agente->celular !== 'null' ) ? $agente->celular : '' }}</td>
                                <td>{{ ( $agente->email !== 'null' ) ? $agente->email : '' }}</td>

                                <td class="td-actions text-right">
                                    <a href="/agentes/{{ $agente->id }}" rel="tooltip" class="btn btn-info" data-original-title="info" title="Información">
                                       <i class="material-icons">insert_drive_file</i>
                                    </a>
                                    <a href="/agentes/{{ $agente->id }}/editar" rel="tooltip" class="btn btn-primary" data-original-title="" title="Editar">
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
                {{ $agentes->links() }}
            </div>

        </div><!-- ./card -->

    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection


@push('scripts')
    @include('layouts.partials.error')
@endpush
