@extends('layouts.master')

@section('title','Mi Perfil')

@section('breadcrump')
   @component('components.breadcrump',[
        'navigation'    =>  [ 'Inicio' => 'inicio', 'Mi Perfil'=>'miPerfil' ],
    ])
    @endcomponent()
@endsection

@section('content')
    <div class="row">
      <div class="col-md-4">
        <div class="card card-profile transparent no-shadow">
          <div class="card-avatar" style="max-width:200px; max-height:200px;">
            @if (auth()->user()->url_avatar)
              <img class="img" src="{{Storage::url(auth()->user()->url_avatar)}}" alt="">
            @else
              <img src="{{asset('img/'.str_replace(" ","-",auth()->user()->perfil->perfil).'.png')}}" alt="..." class="img img-responsive img-circle z-depth-3" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
            @endif
          </div><br>
          <div class="row text-center">
            <h3 class="card-title text-uppercase">{{auth()->user()->nombre}}</h3>
            <h3 class="card-title text-uppercase">{{auth()->user()->apellido}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="card">
            <div class="card-header blue darken-3" data-background-color="">
		          <h4 class="card-title text-uppercase">{{auth()->user()->nombre}} {{auth()->user()->apellido}}</h4>
		          <p class="category text-uppercase">{{auth()->user()->user}} / {{auth()->user()->perfil->descripcion}}</p>
	           </div>
            <div class="card-content">
              <div class="row">
              </div>
              </div>
              <div class="form-horizontal">
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Telefono</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" value="{{auth()->user()->telefono}}" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Celular</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" value="{{auth()->user()->celular}}" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="col-md-2 label-on-left">Email</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" value="{{auth()->user()->email}}" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-2 label-on-left">Dirección</label>
                      <div class="col-md-10">
                        {{--  <input type="text" class="form-control" value="{{auth()->user()->direccion}}" disabled>  --}}
                        <textarea class="form-control" disabled>{{ auth()->user()->direccion }}</textarea>
                      </div>
                    </div>
                  </div>
                @if (!empty(auth()->user()->equipo))
                  <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-2 label-on-left">Equipo</label>
                      <div class="col-md-10">
                        <input type="text" class="form-control" value="{{auth()->user()->equipo->nombre}}" disabled>
                      </div>
                    </div>
                  </div>
                @endif  
                <br>
              </div>
            </div>
            <div class="card-footer text-right">
            <a href="{{auth()->user()->id}}/editar">
              <button type="submit" class="btn blue darken-3">
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                  Editar
              </button>
            </a>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  @endsection
