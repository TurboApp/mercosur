@extends('layouts.master')
@section('title','Mi Perfil')
  @section('nav-top')

  @endsection
  @section('content')
    <div class="row">
      <div class="col-md-4">
        <div class="card card-profile transparent no-shadow">
          <div class="card-avatar" style="max-width:200px; max-height:200px;">
            @if (auth()->user()->url_avatar)
              <img class="img" src="{{Storage::url(auth()->user()->url_avatar)}}" alt="">
            @else
              <img src="{{asset('img/user-default.jpg')}}" alt="...">
            @endif
          </div><br>
          <div class="row text-center">
            <h3 class="card-title text-uppercase">{{auth()->user()->nombre}}</h3>
            <h3 class="card-title text-uppercase">{{auth()->user()->apellido}}</h3>
          </div>
          <hr class="hr">
          <div class="row text-center">
            <label class="label blue darken-3"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{auth()->user()->perfil->perfil}}</label>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="card">
            <div class="card-header blue darken-3" data-background-color="">
		          <h4 class="card-title">{{auth()->user()->nombre}} {{auth()->user()->apellido}}</h4>
		          <p class="category">{{auth()->user()->direccion}}</p>
	           </div>
            <div class="card-content">
              <h4 class="card-title">{{auth()->user()->user}}</h4>
              <div class="row">
              </div>
              {{-- <div class="row">
                <div class="col-md-12 text-left text-uppercase">
                  <h3 class="card-title">{{auth()->user()->nombre}} {{auth()->user()->apellido}}</h3>
                  <h4 class="category">{{auth()->user()->direccion}}</h4>
                </div> --}}
              </div><hr class="hr" style="width:100%;">
              <div class="form-horizontal">
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group">
		                  <span class="input-group-addon">
			                   <i class="fa fa-phone fa-lg" aria-hidden="true"></i>
		                  </span>
		                   <input type="text" class="form-control" value="{{auth()->user()->telefono}}" disabled>
	                  </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
		                  <span class="input-group-addon">
			                   <i class="fa fa-mobile fa-lg" aria-hidden="true"></i>
		                  </span>
		                   <input type="text" class="form-control" value="{{auth()->user()->celular}}" disabled>
	                  </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
		                  <span class="input-group-addon">
			                   <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
		                  </span>
		                   <input type="text" class="form-control" value="{{auth()->user()->email}}" disabled>
	                  </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn blue darken-3">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                 Editar
              </button>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  @endsection
