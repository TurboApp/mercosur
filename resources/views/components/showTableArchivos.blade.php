<card type="header-icon" icon="fa-paperclip" bg-color="blue">
    <template>
        <template slot="title">Archivos</template>
        <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Extensión</th>
                    <th>Peso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($archivos as $index => $archivo)
                    <tr>
                        <td> {{$index + 1 }} </td>
                        <td> {{$archivo->nombre}} </td>
                        <td>
                           <p>
                                @if( $archivo->minetype === 'application/pdf' )
                                    <i class="fa fa-file-pdf-o text-muted fa-lg" aria-hidden="true"></i>
                                @elseif( $archivo->minetype === 'application/vnd.ms-excel' )
                                    <i class="fa fa-file-excel-o text-muted fa-lg" aria-hidden="true"></i>
                                @elseif( $archivo->minetype === 'image/gif' || $archivo->minetype === 'image/jpg' || $archivo->minetype === 'image/jpeg' ||  $archivo->minetype === 'image/png')
                                    <i class="fa fa-file-image-o text-muted fa-lg" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-file-o text-muted fa-lg" aria-hidden="true"></i>
                                @endif
                                .{{$archivo->extension}}
                           </p>
                        </td>
                        <td> {{$archivo->size}} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </template>
    </card>
    