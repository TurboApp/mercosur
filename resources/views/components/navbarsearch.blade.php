{{ Form::open(['action'=>$action,'method'=>'get','class'=>'navbar-form navbar-right','role'=>'search', 'autocomplete'=>'off']) }}
    <div class="form-group form-search is-empty">
        @if(isset($value)) 
            {{ Form::text('s', $value,['placeholder'=>'Buscar','class'=>'form-control']) }}
        @else 
            {{ Form::text('s', '',['placeholder'=>'Buscar','class'=>'form-control']) }}
        @endif
    </div>
    {{ Form::button('<i class="material-icons">search</i>', ['type' => 'submit', 'class' => 'btn btn-white btn-round btn-just-icon'] )  }}
{{ Form::close() }}