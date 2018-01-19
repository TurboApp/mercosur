@extends('layouts.master')
@section('title','Equipo: '. $equipo->nombre )
@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Herramientas' => 'inicio', 'Equipos' => 'equipos' , $equipo-> nombre => '' ],
    ])
    @endcomponent()
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
          <card>
            <template slot="title">{{$equipo->nombre}}</template>
            <p class="lead text-muted">{{$equipo->descripcion}}</p>
            <span>{{$equipo->numero_miembros}} Miembros</span>
          </card>            
        </div>
    </div>
    <div class="row">
        @forelse ($equipo->miembros as $index => $usuario)
          @component('components.card-usuario', ['usuario'=>$usuario] )
          @endcomponent()
        @empty
            <p class="lead text-muted text-center">No hay miembros en este equipo</p>
        @endforelse  
    </div>
   
  @endsection
@push('scripts')
    @include('layouts.partials.errors')
    @include('layouts.partials.notify')
    <script>
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
