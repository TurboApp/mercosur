

<div class="row">
    <div class="col-md-12">
        <div class="search-sup-wrapper">
            <label for="busqueda-supervisor"><i class="fa fa-search fa-lg" aria-hidden="true"></i></label>
            <input id="search-sup" name="busqueda-supervisor" class="search-sup-input" type="text" placeholder="Supervisor...">   
        </div>
    </div>
</div>

<div class="row">
    
        <div id="result-supervisores"></div>
    
</div>


{{--## Modal ## --}}
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <h3 class="modal-title text-primary title" id="myModalLabel">
                    <i class="fa fa-user-o" aria-hidden="true"></i> 
                    <span id="info_nombre"></span>
                    <span id="info_apellido"></span> - 
                    <span class="text-muted" id="info_user"></span>                                
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                             <img class="img img-responsive img-circle z-depth-3" id="info_avatar"    src="">
                            {{--  <figure class="image-hover z-depth-1">
                                <img class="img" id="info_avatar" src="">
                                <figcaption><span id="info_user"></span></figcaption>
                            </figure>  --}}
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label><i class="fa fa-envelope-o" aria-hidden="true"></i></label>
                            <span id="info_email" class="form-control-static"></span>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-home" aria-hidden="true"></i></label>
                            <span id="info_direccion" class="form-control-static"></span>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-phone" aria-hidden="true"></i></label>
                            <span id="info_telefono" class="form-control-static"></span>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-mobile" aria-hidden="true"></i></label>
                            <span id="info_celular" class="form-control-static"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-lg btn-simple" data-dismiss="modal">Cerrar</button>
                    <a id="addLink" href="" class="btn btn-primary" style="margin:0;">Agregar supervisor</a>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
    /*
        $(function(){
            
            let resp = $('#result-supervisores');
            let sp = $('#search-sup');
            
            axios.get('/API/supervisores/')
            .then(function (response) {
                    if(response.data.length>0){
                        $.each(response.data, function(i, el){
                            $(`
                            <div class="col-sm-6">
                                <div class="card card-profile card-plain">
                                <div class="col-md-5">
                                    <div class="">
                                        <img class="img img-responsive img-circle z-depth-3" src="`+el.url_avatar.replace('public/','/storage/')+`" onerror='this.onerror = null; this.src="/img/supervisor.png"'>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-content">
                                    <h4 class="card-title text-truncate" title="` + el.nombre +' '+ el.apellido + `">` + el.nombre + ' ' + el.apellido + `</h4>
                                    <h6 class="category text-muted text-truncate" title="Usuario: `+ el.user + `">
                                        <i class="fa fa-user-circle-o fa-1 text-muted" aria-hidden="true"></i> ` + el.user +`
                                    </h6>
                                    <div class="footer">
                                        <button type="button" data-id="`+ el.id +`" class="add_supervisor btn btn-primary btn-simple btn-just-icon ">
                                            <i class="fa fa-plus" aria-hidden="true"></i> 
                                        </button>
                                        <button type="button" data-id="`+ el.id +`"  class="info-supervisor btn btn-success btn-simple btn-just-icon" data-toggle="modal" data-target="#modalInfo">
                                            <i class="fa fa-info" aria-hidden="true"></i> 
                                        </button>
                                        
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>



                               
                              
                            `).hide().appendTo(resp).fadeIn(400);
                        });
                    }else{
                        $(`<p class="lead text-muted text-center" style="margin-top:60px;">
                            No se encontraron resultados</p>`).hide().appendTo(resp).fadeIn(400);
                    }
            })
            
            var delay = (function(){
                var timer = 0;
                return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            sp.on('keyup', function(){
                axios.get('/API/supervisores/'+$(this).val())
                .then(function (response) {
                    delay(function(){
                        resp.html("");
                        if(response.data.length>0){
                            $.each(response.data, function(i, el){
                                
                                $(`
                                   <div class="col-sm-6">
                                <div class="card card-profile card-plain">
                                <div class="col-md-5">
                                    <div class="">
                                        <img class="img img-responsive img-circle z-depth-3" src="`+el.url_avatar.replace('public/','/storage/')+`" onerror='this.onerror = null; this.src="/img/supervisor.png"'>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-content">
                                    <h4 class="card-title text-truncate" title="` + el.nombre +' '+ el.apellido + `">` + el.nombre + ' ' + el.apellido + `</h4>
                                    <h6 class="category text-muted text-truncate" title="Usuario: `+ el.user + `">
                                        <i class="fa fa-user-circle-o fa-1 text-muted" aria-hidden="true"></i> ` + el.user +`
                                    </h6>
                                    <div class="footer">
                                        <button type="button" data-id="`+ el.id +`" class="add_supervisor btn btn-primary btn-simple btn-just-icon ">
                                            <i class="fa fa-plus" aria-hidden="true"></i> 
                                        </button>
                                        <button type="button" data-id="`+ el.id +`"  class="info-supervisor btn btn-success btn-simple btn-just-icon" data-toggle="modal" data-target="#modalInfo">
                                            <i class="fa fa-info" aria-hidden="true"></i> 
                                        </button>
                                        
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                                `).hide().appendTo(resp).fadeIn(400);
                            });
                        }else{
                            $(`<p class="lead text-muted text-center" style="margin-top:60px;">
                                No se encontraron resultados</p>`).hide().appendTo(resp).fadeIn(400);
                        }

                    }, 500);
                })
                .catch(function (error) {
                    console.log(error);
                });  
                
            });

            //init();


            //Modal
            $(document).on("click",".info-supervisor", function(){
                let id = $(this).data('id');
                $("#info_user").html("");
                $("#info_avatar").attr("src","");
                $("#addLink").attr("href","");

                $('#info_nombre').html("");
                $('#info_apellido').html("");
                $('#info_email').html("");
                $('#info_direccion').html("");
                $('#info_telefono').html("");
                $('#info_celular').html("");
                
                axios.get('/API/info-user/'+id)
                .then(function(response){
                    let data=response.data;
                    $('#info_user').text(data.user);
                    if(data.url_avatar.length > 1){
                        $('#info_avatar').attr("src",data.url_avatar.replace("public/", "/storage/"));
                    }else{
                        $('#info_avatar').attr("src",'/img/supervisor.png');
                    }
                    $('#addLink').attr("href","/coordinacion/servicio/agregar_supervisor/{{$servicio->id}}/"+id);

                    $('#info_nombre').text(data.nombre);
                    $('#info_apellido').text(data.apellido);
                    $('#info_email').text(data.email);
                    $('#info_direccion').text(data.direccion);
                    $('#info_telefono').text(data.telefono);
                    $('#info_celular').text(data.celular);
               
                }); 
            });


            //sweed Alert
            $(document).on("click",".add_supervisor", function(){
                let id = $(this).data('id');
                axios.get('/API/info-user/'+id)
                .then(function(response){
                    let data=response.data;
                    console.log(data);
                    swal({
                        showCancelButton: true,
                        html: `
                            <img class="z-depth-4 img img-circle img-resposive" src="`+ data.url_avatar.replace('public/','/storage/') +`" onerror='this.onerror = null; this.src="/img/supervisor.png"' style="max-width:120px;margin:0 auto;">
                            <h3 class="title">`+ data.nombre +' '+ data.apellido +`</h3>
                            <h6 class="text-muted text-uppercase">`+ data.user +`</h6>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey:false,
                        cancelButtonClass: 'btn btn-simple btn-primary',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'Agregar',
                        cancelButtonText: 'Cancelar',
                        buttonsStyling: false
                        })
                        .then(function () {
                           location.href="/coordinacion/servicio/agregar_supervisor/{{$servicio->id}}/"+id; 
                    })//End swal
                }); 
            });


        });
        */
    </script>

@endpush