 @if(count($errors))
    <script>
    $(document).ready(function(){
        $.notify({
            icon: "warning",
            message: "<strong>¡Upss! Ha ocurrido un problema.</strong>  @foreach($errors->all() as $error)  <li> {{ $error }} </li>  @endforeach"
        },
        {
            type: 'warning',
            timer: 4000,
            placement: 
            {
                from: 'top',
                align: 'right'
            }
        });
    });
</script>  
    
        
@endif
