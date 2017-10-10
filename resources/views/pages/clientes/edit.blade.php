@extends('layouts.master')

@section('title','Editar datos de cliente')

@section('nav-top')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/clientes/{{$cliente->id}}" title="Cancelar">
                <i class="material-icons">cancel</i>
                <p class="hidden-lg hidden-md">Cancelar</p>
            </a>
        </li>
        <li class="separator hidden-lg hidden-md"></li>
    </ul>
    @component('components.navbarsearch',[
        'action'    => 'ClienteController@search',
    ])
    @endcomponent()
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form id="editCliente" method="POST" action="/clientes/{{ $cliente->id }}" class="form-horizontal" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="card-header card-header-icon" data-background-color="blue">
                    <i class="material-icons">edit</i> 
                </div>
                <div class="card-content">
                    <h4 class="card-title">Edite los datos</h4>
                    <div class="row">
                        <div class="form-group label-floating is-empty">
                            <label class="col-sm-2 label-on-left" for="nombre">* Nombre</label>
                            <div class="col-sm-10">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" name="nombre" value="{{ $cliente->nombre }}" maxlength="90" required="true">
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                    </div><!-- -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Nombre corto</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="nombre_corto" value="{{ $cliente->nombre_corto }}" maxlength="30" required>
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-sm-2 label-on-left">RFC</label>
                                <div class="col-sm-10">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="rfc" value="{{ $cliente->rfc }}" maxlength="15" required>
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Email</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-3">                           
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="email" class="form-control" name="email" value="{{ $cliente->email }}" maxlength="60" email="true" >
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5"> 
                                    <div class="row">     
                                        <label class="col-sm-3 label-on-left">Teléfono</label>
                                        <div class="col-sm-9 ">                     
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="telefono" value="{{ $cliente->telefono }}" maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="row">     
                                        <label class="col-sm-3 label-on-left">Celular</label>
                                        <div class="col-sm-9">                     
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name="celular" value="{{ $cliente->celular }}" maxlength="20">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div><!-- ./row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-4 label-on-left">Ciudad</label>
                                <div class="col-md-8">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="ciudad" value="{{ $cliente->ciudad }}" maxlength="60">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="col-md-3 label-on-left">Codigo postal</label>
                                <div class="col-md-9">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control" name="codigo_postal" value="{{ $cliente->codigo_postal }}" maxlength="10">
                                        <span class="material-input"></span>
                                    </div>
                                </div><!-- ./col-md-10 -->
                            </div>
                        </div>
                    </div><!-- ./row -->
                    
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Dirección</label>
                        <div class="col-sm-10">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <textarea class="form-control" name="direccion" maxlength="191">{{ $cliente->direccion }}</textarea>
                                <span class="material-input"></span>
                            </div>
                        </div><!-- ./col-md-10 -->
                    </div>
                </div><!-- ./card-content -->
                <div class="card-footer text-right">
                    <hr>
                    <nav class="navs pull-right">
                        <ul class="list-inline">
                            <li>
                                <a href="/clientes/{{$cliente->id}}" class="btn btn-danger btn-simple delete-cliente">
                                    <i class="material-icons">cancel</i>
                                    Cancelar
                                </a>
                            </li>
                            <li>
                                 <button type="submit" class="btn btn-primary btn-round">
                                    <i class="material-icons">save</i>
                                    Guardar
                                </button>
                            </li>
                        </ul>
                    </nav>
                   
                </div><!-- ./card-footer -->
            </form>
        </div>  <!-- ./card -->         
   
    </div>
</div>
@endsection


@push('scripts')

     @include('layouts.partials.errors')

    <script>
      $('#editCliente').validate({
            errorPlacement: function(error, element) {
                $(element).parent('div').addClass('has-error');
            }
        });

    </script>

@endpush