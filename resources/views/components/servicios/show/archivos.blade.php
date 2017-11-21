<card>
    <template>
        <ul class="files-list">
            @foreach($data as $index => $archivo)
                <li class="file-item">
                    <a href="{{ url($archivo->url) }} " target="_blank">
                        <div class="file-icon">
                            @if($archivo->extension === "xls" || $archivo->extension === "xlsx")
                                <img src="/img/iconos/xls.svg">
                            @elseif($archivo->extension === "docx" || $archivo->extension === "doc")
                                <img src="/img/iconos/doc.svg">
                            @elseif($archivo->extension === "ppt" || $archivo->extension === "pptx")
                                <img src="/img/iconos/ppt.svg">
                            @elseif($archivo->extension === "pdf")
                                <img src="/img/iconos/pdf.svg">
                            @else
                                <img src="{{url($archivo->url)}}" style="padding:auto 15px;">
                            @endif
                        </div>

                        <div class="file-details">
                            <h6 class="file-name text-truncate"><b>{{ $archivo->nombre }}</b></h6>
                            <span class="file-size">{{ $archivo->size }}</span>
                            <span class="file-minetype text-truncate-ln4">{{ $archivo->minetype }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        @foreach($data as $index => $archivo)
        
            {!! Form::hidden('archivo['.$index.'][id]',$archivo->id) !!}
            
        @endforeach

    </template>
</card>
