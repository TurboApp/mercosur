@if(isset($icon))
<card icon="{{ $icon }}" bg-color="blue" type="header-icon">
@else
<card>
@endif
<template>  
    @if(isset($title))
          <span slot="title"> {{ $title }} </span> 
    @endif
    @if(!count($datos))
        <h2 class="text-center text-muted">No se encontraron resultados</h2>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>{{ $name }}</th>
                        <th>RFC</th>
                        <th>Telèfono</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th>{{ $name }}</th>
                        <th>RFC</th>
                        <th>Telèfono</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($datos as  $index => $dato)
                        <tr>
                            <td class="text-center"> {{ (( $datos->currentPage() - 1 ) * $datos->perPage() ) + ( $index + 1 ) }}</td>
                            <td>{{ $dato->nombre }} ( {{$dato->nombre_corto}} )</td>
                            <td>{{ ( $dato->rfc !== 'null' ) ? $dato->rfc : '' }}</td>
                            <td>{{ ( $dato->telefono !== 'null' ) ? $dato->telefono : '' }}</td>
                            <td>{{ ( $dato->celular !== 'null' ) ? $dato->celular : '' }}</td>
                            <td>{{ ( $dato->email !== 'null' ) ? $dato->email : '' }}</td>

                            <td class="td-actions text-right">
                                <a href="/{{$url}}/{{ $dato->id }}" rel="tooltip" class="btn btn-info" data-original-title="info" title="Información">
                                    <i class="material-icons">insert_drive_file</i>
                                </a>
                                <a href="/{{$url}}/{{ $dato->id }}/editar" rel="tooltip" class="btn btn-primary" data-original-title="" title="Editar">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- ./table-responsive -->
    @endif
    <slot name="footer">
        <div class="col-md-6">
            <p class="form-group" style="padding:20px 0;">
                Mostrando registros del {{ ( ( $datos->currentPage() - 1 ) * $datos->perPage() ) + 1 }} al {{ ( ( $datos->currentPage() - 1 ) * $datos->perPage() ) + $datos->count() }} de un total de {{ $datos->total()  }} registros
            </p>
        </div>
        <div class="col-md-6 text-right">
            {{ $datos->links() }}
        </div>
    </slot> 
</template>
</card>
