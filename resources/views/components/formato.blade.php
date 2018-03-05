@if ($tipo=="Descarga" || $tipo=="Carga")
    <table border=".5px" cellspacing="0" bordercolor="Blue Grey" style="width:100%;">
        <col width="400">
            @component('components.Cformato.mercancia',[
                'data' => $data,
                'fecha' => $fecha,
                'tipo' => $tipo,
            ])
            @endcomponent()

            @component('components.Cformato.vehiculo',[
                'data' => $data,
                'fecha' => $fecha,
                'tipo' => $tipo,
            ])
            @endcomponent()

            @component('components.Cformato.firma',[
                'data' => $data,
                'fecha' => $fecha,
                'tipo' => $tipo,
            ])
            @endcomponent()
    </table>
@endif

@if ($tipo=="Trasbordo")
    <table border=".5px" cellspacing="0" bordercolor="Blue Grey" style="width:100%;">
        <col width="400">
        @component('components.Cformato.mercancia',[
            'data' => $data,
            'fecha' => $fecha,
            'tipo' => $tipo,
        ])
        @endcomponent()
        
        @component('components.Cformato.vehiculo',[
            'data' => $data,
            'fecha' => $fecha,
            'tipo' => $tipo,
        ])
        @endcomponent()

        @component('components.Cformato.firma',[
            'data' => $data,
            'fecha' => $fecha,
            'tipo' => $tipo,
        ])
        @endcomponent()
    </table>

    <page pageset="old">
        <table border=".5px" cellspacing="0" bordercolor="Blue Grey" style="width:100%;">
            <col width="400">
            @component('components.Cformato.mercanciaT',[
                'data' => $data,
                'fecha' => $fecha,
                'tipo' => $tipo,
            ])
            @endcomponent()
    
            @component('components.Cformato.vehiculoT',[
                'data' => $data,
                'fecha' => $fecha,
                'tipo' => $tipo,
            ])
            @endcomponent()
    
            @component('components.Cformato.firmaT',[
                'data' => $data,
                'fecha' => $fecha,
                'tipo' => $tipo,
            ])
            @endcomponent()
        </table>
    </page>
@endif