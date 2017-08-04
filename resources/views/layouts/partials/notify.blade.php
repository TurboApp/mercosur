@foreach (['danger' => 'error', 'warning' => 'warning', 'success' => 'check', 'info' => 'notifications'] as $notify => $icon)
    @if(Session::has($notify))
       <script>
            $(document).ready(function(){
                $.notify({
                    icon: "{{ $icon }}",
                    message: "{{session($notify)}}"
                },
                {
                    type: '{{$notify}}',
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
@endforeach
