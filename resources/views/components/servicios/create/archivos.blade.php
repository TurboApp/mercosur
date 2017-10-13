<card type="header-icon" icon="fa-paperclip">
    <template>
        <template slot="title">Archivos</template>
        <a class="file_input btn-simple btn btn-primary btn-block" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif, pdf, xls, xlsx, ppt, pptx, doc, docx">
            <i class="material-icons">attach_file</i>
            Adjuntar archivos
        </a> 
    </template>
</card>

@push('scripts')
<script>
    $(function(){
        $('.file_input').on('click',function(){
            console.log("Click");
        });
        $('.file_input').filer({
            showThumbs: true,
            maxSize: 2,
            templates: {
                box: '<ul class="jFiler-item-list"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        @{{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">@{{fi-icon}} @{{fi-size2}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        @{{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <span class="jFiler-item-others">@{{fi-icon}} @{{fi-size2}}</span>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-item-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action',
                }
            },
            addMore: true,
            captions: {
                button: "Seleccionar archivos",
                feedback: "Seleccionar archivos para subir",
                feedback2: "Los archivos fueron elejidos",
                drop: "Descargar archivo aquí para cargar",
                removeConfirmation: "¿Seguro que quieres eliminar este archivo?",
                errors: {
                    filesLimit: "Sólo se pueden cargar un maximo de @{{fi-limit}} archivos.",
                    filesType: "Este tipo de archivo no es valido",
                    filesSize: "¡El archivo '@{{fi-name}}' es muy grande! \nPor favor cargue achivos no mayores a @{{fi-maxSize}} MB.",
                    filesSizeAll: "¡El total de carga de los archvivos que has elegido supera los @{{fi-maxSize}}!\nPor favor cargue archivos menores a @{{fi-maxSize}} MB."
                }
            },
            files: []
        });
    });
</script>

@endpush()