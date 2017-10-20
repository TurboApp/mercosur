@extends('layouts.master')
@section('title','Cards de Usuarios')
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
    <form class="navbar-form navbar-right" method="GET" action="/usuarios/busqueda/" role="search">
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
    @if (!count($usuarios))
      <h2 class="text-center text-muted">No hay datos que mostrar</h2>
    @else
      <div class="row">
        @foreach ($usuarios as $index => $usuario)
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  @if ($usuario->url_avatar)
                    <img class="img" src="{{Storage::url($usuario->url_avatar)}}" alt="">
                  @else
                    <img src="{{asset('img/user-default.jpg')}}" alt="...">
                  @endif
                </div>
                <div class="card-content">
                  <h3 class="card-title">{{$usuario->nombre}}</h3>
                  @foreach ($usuario->puestos as $puesto)
                    {{$puesto->puesto}}
                  @endforeach
                  <h6 class="category text-gray">{{$usuario->celular}}</h6>
                  <br>
                  <hr>
                  <div class="row">
                    <div class="col-md-6 text-center">
                      <i class="fa fa-user-circle-o fa-2x text-muted" aria-hidden="true"></i>
                      <h4 class="category text-gray">{{$usuario->user}}</h4>
                    </div>
                    <div class="col-md-6 text-center">
                      <i class="fa fa-key fa-2x text-muted" aria-hidden="true"></i>
                      <h4 class="category text-gray">{{$usuario->perfil->descripcion}}</h4>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <a href="/usuarios/{{$usuario->id}}"><button type="button" class="btn btn-primary btn-block btn-round">Ver Detalles</button></a>
                  </div>
                  </div>
                </div>
              </div>
          @endforeach
        </div>
    @endif
  @endsection
  @push('scripts')

    @include('layouts.partials.notify')

    <script>
       $(document).ready(function(){
         var e = $('.delete-user');

         e.click(function(){
           var url= $(this).data('url');
           var ID=$(this).data('id');
           var re= $(this).data('redirect');
           console.log('url');
           console.log(url);
           console.log('re');
           console.log(re);
                 swal({
                     showCancelButton: true,
                     title: '¿Esta seguro?',
                     text: "¡No podrás revertir esto!",
                     type: 'warning',
                     allowOutsideClick: false,
                     allowEscapeKey:false,
                     confirmButtonClass: 'btn btn-success',
                     cancelButtonClass: 'btn btn-danger',
                     confirmButtonText: 'Si, ¡Eliminar!',
                     cancelButtonText: 'No, Cancelar',
                     buttonsStyling: false
                     }).then(function () {
                       console.log('url dentro');
                       console.log(url);
                       axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                         axios({
                             method:'delete',
                             url:url,
                             params:{
                               id:ID
                             }

                         }).then(function(response){
                           console.log(response);
                         });

                     swal({
                         allowOutsideClick: false,
                         allowEscapeKey:false,
                         title: '¡Eliminando!',
                         text: 'El registro esta siendo eliminado...',
                         type: 'success',
                         confirmButtonClass: "btn btn-success",
                         buttonsStyling: false
                         }).then(function(){

                            window.location = re;


                         })
                     }, function (dismiss) {
                     // dismiss can be 'cancel', 'overlay',
                     // 'close', and 'timer'
                     if (dismiss === 'cancel') {
                         swal({
                           title: 'Cancelado',
                           text: 'El registro esta seguro :)',
                           type: 'error',
                           confirmButtonClass: "btn btn-info",
                           buttonsStyling: false
                         })
                     }
                     })

         });


       });
       </script>
  @endpush
