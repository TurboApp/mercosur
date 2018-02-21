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
            <table id="datatable" class="table" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr>
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
                        <th>{{ $name }}</th>
                        <th>RFC</th>
                        <th>Telèfono</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                  
                </tbody>
            </table>
        </div><!-- ./table-responsive -->
    @endif
    
</template>
</card>

@push('scripts')
<script>
    $().ready(function(){
        
        $('#datatable').DataTable( {
            order: [],
            responsive: true,
            processing: true,
            serverSide: true,
    @if(isset($filter))
        @if(!$filter)
            searching: false,
        @endif
    @endif
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                sInfoPostFix: "",
                sSearch: "Buscar:",
                sUrl: "",
                sInfoThousands: ",",
                sLoadingRecords: "Cargando...",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                },
                oAria: {
                    sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            },
            ajax: "{{$ajax}}",
            columns :[
                { 
                    data : "nombre",
                    render: function(data, type, row){
                        return data + ' ('+ row.nombre_corto +')';
                    }
                },
                
                { 
                    data : "rfc",
                },
                
                { 
                    data : "telefono",
                },

                { 
                    data : "celular",
                },

                { 
                    data : "email",
                },

                {
                    orderable: false,
                    data: null,
                    render: function(data, type, row){
                       return `<p class="text-center">
                                    <a href="/{{$urlTo}}/`+row.id+`" rel="tooltip" class="btn btn-info btn-simple btn-icon" data-original-title="info" title="Información">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                    </a>
                                @if(auth()->user()->perfil->perfil == 'admin')
                                    <a href="/{{$urlTo}}/`+row.id+`/editar" rel="tooltip" class="btn btn-warning btn-simple btn-icon" data-original-title="" title="Editar">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                @elseif(auth()->user()->perfil->perfil == 'go')
                                    <a href="/{{$urlTo}}/`+row.id+`/metricas" rel="tooltip" class="btn btn-success btn-simple btn-icon" data-original-title="" title="Metricas">
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </p>
                       `;
                       
                    },
                    
                }
                
            ]
        } );
       
        $.fn.dataTable.ext.errMode = 'throw'; 


    });
</script>
@endpush