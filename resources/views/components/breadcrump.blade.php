@if (!Request::is('/'))
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">

            @foreach($navigation as $nav => $link )
                
                @if($loop->first)
                    <li class="breadcrumb-item active text-capitalize" aria-current="page">
                        <a href="{{ route( 'inicio' ) }}">
                            <i class="fa fa-home" aria-hidden="true"></i> Inicio
                        </a>
                    </li>
                @elseif($loop->last)
                    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{$nav}}</li>
                @else
                    <li class="breadcrumb-item text-capitalize"><a href="{{ route( $link ) }}">{{$nav}}</a></li>
                @endif 

            @endforeach
            
        </ol>
    </nav>
@else
    <div style="padding: 8px 0;">
        Bienvenido, <b>{{ auth()->user()->nombre }}</b>. 
    </div>
@endif