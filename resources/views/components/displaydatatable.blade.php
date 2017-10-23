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
            <table id="datatable" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
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
            language: {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
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
                                <a href="/{{$urlTo}}/`+row.id+`/editar" rel="tooltip" class="btn btn-warning btn-simple btn-icon" data-original-title="" title="Editar">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
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