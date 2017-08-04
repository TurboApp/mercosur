<script>
   $(document).ready(function(){
        
       $('.{{$class}}').click(function(){
            swal({
                showCancelButton: true,
                title: '¿Esta seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                allowOutsideClick: false,
                allowEscapeKey:false,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, ¡Eliminar!',
                cancelButtonText: 'No, Cancelar',
                buttonsStyling: false
                }).then(function () {
                    axios({
                        method:'delete',
                        url:'{{$url}}',
                    });
                        
                swal({
                    allowOutsideClick: false,
                    allowEscapeKey:false,
                    title: '¡Eliminando!',
                    text: 'El registro esta siendo eliminado...',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).then(function(){
                        
                       window.location = "{{$redirect}}";
                        
                    })
                }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                    swal({
                      title: 'Cancelado',
                      text: 'El registro esta seguro :)',
                      type: 'error',
                      confirmButtonClass: "btn btn-info",
                      buttonsStyling: false
                    })
                }
                })
       });
       
   });
   </script>