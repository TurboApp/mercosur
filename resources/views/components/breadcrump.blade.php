 <nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        
        @foreach($navigation as $nav => $link )
            
            @if($loop->last)
                <li class="breadcrumb-item active text-capitalize" aria-current="page">{{$nav}}</li>
            @else
                <li class="breadcrumb-item text-capitalize"><a href="{{ route( $link ) }}">{{$nav}}</a></li>
            @endif 

        @endforeach
        
    </ol>
</nav>