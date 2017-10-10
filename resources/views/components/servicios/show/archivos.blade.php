<card type="header-icon" icon="fa-folder-open-o">
    <template>
        <template slot="title">Archivos</template>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Extensión</th>
                    <th>Tamaño</th>
                    <th>Tipo de archivo</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Extensión</th>
                    <th>Tamaño</th>
                    <th>Tipo de archivo</th>
                </tr>  
            </tfoot>
            <tbody>
                @foreach($data as $index => $archivo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $archivo->nombre }}</td>
                        <td>{{ $archivo->extension }}</td>
                        <td>{{ $archivo->size }}</td>
                        <td>{{ $archivo->minetype }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @foreach($data as $index => $archivo)
        
            {!! Form::hidden('archivo['.$index.'][id]',$archivo->id) !!}
            
        @endforeach

    </template>
</card>