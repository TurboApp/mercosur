

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


{{--  ## Modal ## --}}
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
                    <span id="info_apellido"></span>                                
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <figure class="image-hover z-depth-1">
                                <img class="img" id="info_avatar" src="">
                                <figcaption><span id="info_user"></span></figcaption>
                            </figure>
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
                    <button type="button" onClick="alert('Agrega supervisor');" class="btn btn-primary" style="margin:0;">Agregar supervisor</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(function(){
            
            let resp = $('#result-supervisores');
            let sp = $('#search-sup');
            
            axios.get('/API/supervisores/')
            .then(function (response) {
                    if(response.data.length>0){
                        $.each(response.data, function(i, el){
                            let nombreCompleto= el.nombre +' '+el.apellido;
                            if(nombreCompleto.length>20){
                               nombreCompleto = nombreCompleto.substr( 0, 17 ) + '...';     
                            }
                            $(`
                                <div class="col-md-6">
                                    <div class="card card-profile card-plain">
                                    <div class="col-xs-12 col-sm-5">
                                        <div class="card-image">
                                            <img class="img" src="/storage/`+el.url_avatar+`" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-7">
                                        <div class="card-content">
                                            <h3 class="card-title" title="`+ el.nombre +' '+el.apellido +`">`+ nombreCompleto +`</h3>
                                            <div class="footer">
                                                <button type="button" data-id="`+ el.id +`" class="add_supervisor btn btn-just-icon btn-round btn-primary ">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> 
                                                </button>
                                                <button type="button" data-id="`+ el.id +`"  class="info-supervisor btn btn-just-icon btn-round btn-info" data-toggle="modal" data-target="#modalInfo">
                                                    <i class="fa fa-info" aria-hidden="true"></i> 
                                                </button>
                                                    
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr class="visible-xs">
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
                                let nombreCompleto= el.nombre +' '+el.apellido;
                                if(nombreCompleto.length>20){
                                nombreCompleto = nombreCompleto.substr( 0, 17 ) + '...';     
                                }
                                $(`
                                    <div class="col-md-6">
                                        <div class="card card-profile card-plain">
                                        <div class="col-xs-12 col-sm-5">
                                            <div class="card-image">
                                                <img class="img" src="`+el.url_avatar+`" onerror='this.onerror = null; this.src="/img/user-default.jpg"'>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-7">
                                            <div class="card-content">
                                                <h3 class="card-title" title="`+el.nombre +' '+el.apellido+`">`+ nombreCompleto +`</h3>
                                                <div class="footer">
                                                    <button type="button" data-id="`+ el.id +`" class="add_supervisor btn btn-just-icon btn-round btn-primary ">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> 
                                                    </button>
                                                    <button type="button" data-id="`+ el.id +`" class="info-supervisor btn btn-just-icon btn-round btn-info" data-toggle="modal" data-target="#modalInfo">
                                                        <i class="fa fa-info" aria-hidden="true"></i> 
                                                    </button>
                                                        
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr class="visible-xs">
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
                        $('#info_avatar').attr("src",'/storage/'+data.url_avatar);
                    }else{
                        $('#info_avatar').attr("src",'/img/user-default.jpg');
                    }

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
                            <img class="z-depth-4 img img-circle img-resposive" src="`+ data.url_avatar +`" onerror='this.onerror = null; this.src="/img/user-default.jpg"' style="max-width:120px;margin:0 auto;">
                            <h3 class="title">`+ data.nombre +' '+ data.apellido +`</h3>
                            <h6 class="text-muted text-uppercase">`+ data.user +`</h6>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey:false,
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonClass: 'btn btn-simple btn-primary',
                        confirmButtonText: 'Agregar',
                        cancelButtonText: 'Cancelar',
                        buttonsStyling: false
                        })
                        .then(function () {
                           location.href="/trafico/maniobra/agregar_supervisor/{{$servicio->id}}/"+id; 
                    })//End swal
                }); 
            });


        });
        
    </script>

@endpush