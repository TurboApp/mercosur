@extends('layouts.app')
@section('content')
  <div class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="black" data-image="/img/login_1.jpg">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
              <form class="" action="{{route('login')}}" method="post">
                {{ csrf_field() }}
                <div class="card card-login card-hidden">
                  <div class="card-header text-center" data-background-color="blue">
                    <h4 class="card-title">Login</h4>
                  </div>
                  <p class="category text-center">Inicio de Sesion</p>
                  <div class="card-content">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">face</i>
                      </span>
                      <div class="form-group label-floating">
                        <label class="control-label">Usuario</label>
                        <input id="user" type="text" class="form-control" name="user" value="{{ old('user') }}" required>
                      </div>
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                      </span>
                      <div class="form-group label-floating">
                        <label class="control-label">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                      </div>
                    </div>
                  </div>
                  <div class="footer text-center">
                    <button type="submit" class="btn btn-primary btn-simple btn-wd btn-lg">Ingresar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  @include('layouts.partials.errors')
  <script type="text/javascript">
    $(function() {
        app.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>
@endpush
