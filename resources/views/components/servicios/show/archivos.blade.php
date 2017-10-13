<card type="header-icon" icon="fa-folder-open-o">
    <template>
        <template slot="title">Archivos</template>
        <ul class="files-list">
            @foreach($data as $index => $archivo)
                <li class="file-item">
                    <a href="{{ url($archivo->url) }} ">
                        <div class="file-icon">
                            @if($archivo->extension === "xls")
                                <img src="/img/iconos/xls.svg">
                            @elseif($archivo->extension === "xlsx")
                                <img src="/img/iconos/excel.svg">

                            @elseif($archivo->extension === "pdf")
                                <img src="/img/iconos/pdf.svg">
                            @elseif($archivo->extension === "jpg")
                                <img src="{{Storage::url($archivo->url)}}">
                            @endif
                        </div>

                        <div class="file-details">
                            <span class="file-name"><b>{{ $archivo->nombre }}</b></span>
                            <span class="file-size">{{ $archivo->size }}</span>
                            <span class="file-minetype">{{ $archivo->minetype }}</span>
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