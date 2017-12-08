<?php

namespace App;

use DateTime;
use Nicolaslopezj\Searchable\SearchableTrait;

class Servicio extends Model
{
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'servicios.destino' => 10,
        ],
    ];
    
    protected $dates=['fecha_recepcion'];

    public static function getNumServicio()
    {
        if(Servicio::orderBy('id','desc')->first()){
            return Servicio::orderBy('id','desc')->first()->id + 1;
        }else{
            return 1;
        }
    }

    public static function storeDatosGenerales($data)
    {
        $datos_generales = array();
        $datos_generales = $data;
        $numero_servicio = Servicio::getNumServicio();
        $date = str_replace('/', '-', $datos_generales['fecha_recepcion']);
        $datos_generales['numero_servicio'] = $numero_servicio;
        $datos_generales['fecha_recepcion'] = date('Y-m-d', strtotime($date));
        
        return Servicio::create($datos_generales);
    }

    public function storeTransportes($data)
    {
        foreach($data as $transporte){
            foreach($transporte as $operacion => $data){
                ServicioTransporte::create(
                    ['servicio_id' => $this->id, 
                    'operacion' => $operacion ] +
                    $data
                );

            }
            
        }
    }

    public function storeDocumentos($data)
    {   
        foreach($data as $documento){
            if( array_key_exists( 'documento_padre' , $documento ) )
            {
                ServicioMercanciaDocumento::create( $documento + [ 'servicio_id' => $this->id ] );
                $id = (int) $documento['documento_padre'];
                $update = ServicioMercanciaDocumento::findOrFail($id);
                $update->fill([ "status" => "0" ])->save();
            }else{
                if($this->tipo == 'Descarga')
                {
                    ServicioMercanciaDocumento::create( $documento + [ 'servicio_id' => $this->id,  'status' => '1' ] );
                }
                else
                {
                    ServicioMercanciaDocumento::create( $documento + [ 'servicio_id' => $this->id  ] );
                }
            }
            
            
        }
    }

    public function storeArchivos($archivos){
        foreach ($archivos as $archivo) 
        {
            $now = new DateTime();
            $size = (int) $archivo->getClientSize();
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            $file['url'] = $archivo->storeAs('documentos/'.$this->numero_servicio, $now->getTimestamp().'-'.$archivo->getClientOriginalName());
            $file['size'] = round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
            $file['extension'] = $archivo->getClientOriginalExtension();
            $file['nombre'] = $archivo->getClientOriginalName();
            $file['minetype'] = $archivo->getClientMimeType();
            ServicioArchivo::create( [ 'servicio_id' => $this->id] + $file );
        }
    }

    //Crea relacion con coordinacion
    public function asignarTurno($fecha)
    {
        $date = str_replace('/', '-', $fecha);
        $date=date('Y-m-d', strtotime($date));
        $coordinacion = Coordinacion::whereDate( 'created_at', $date )->orderBy('turno','desc')->first();
        
        if($coordinacion){
            $turno = $coordinacion->turno + 1; 
        }else{
            $turno = 1;
        }
        
        //Store Coordinacion - coordinacions
        $coordinacion = Coordinacion::create([
            'servicio_id' => $this->id,
            'turno'             => $turno,
            'fecha_servicio'    => $date
        ]);
        
        

        return $coordinacion->id;
    }

    public function prepararTareas($coordinacion_id)
    {
        if($this->tipo==='Descarga')
        {
            $taks = $this->tareasDescarga($coordinacion_id);
        }
        elseif($this->tipo==='Carga'){
            $taks = $this->tareasCarga($coordinacion_id);
        }

        for($i = 0; $i < count($taks); $i++)
        {
            $tarea = ManiobraTarea::create( $taks[$i]["tarea"] );
            for($x = 0 ; $x < count($taks[$i]["subtareas"]); $x++){
                ManiobraSubtarea::create( ["tarea_id" => $tarea->id] +  $taks[$i]["subtareas"][$x] );
            }
        }


    }

    //Relaciones
    //uno a uno
    public function cliente(){
        return $this->hasOne('App\Cliente','id','cliente_id');  
    }
    public function agente(){
        return $this->hasOne('App\Agente','id','agente_id');  
    }
    public function coordinacion()
    {
        return $this->hasOne('App\Coordinacion','servicio_id','id');
    }
    public function autor()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    //uno a muchos
    public function documentos()
    {
        return $this->hasMany('App\ServicioMercanciaDocumento','servicio_id','id');
    }

    public function transportes()
    {
        return $this->hasMany('App\ServicioTransporte','servicio_id','id');
    }
    public function archivos()
    {
        return $this->hasMany('App\ServicioArchivo','servicio_id','id');
    }
    
    public function children()
    {
        return $this->hasMany('App\servicio','servicio_padre','id');
    }
    public function parent()
    {
        return $this->belongsTo('App\Servicio', 'servicio_padre');    
    }


    //Tareas

    public function tareasDescarga($coordinacion_id)
    {
       
        return [
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Revisión",
                    "titulo_largo" => "Recepción y revisión de ordenes",
                    "avance" => 5,
                    "icono" => "fa fa-search",
                ],
                "subtareas" =>  [
                    ["subtarea" => "Documentación", "texto_ayuda" => "Asegurese de contar con la documentación correcta y completa",  "inputType" => "check"],
                    ["subtarea" => "Nombre del perador", "texto_ayuda" => "Comprube si el operador de la unidad se identifica con el nombre correcto", "inputType" => "check"],
                    ["subtarea" => "Placa cabezal", "texto_ayuda" => "Revise si la placa del cabezal es la correcta",  "inputType" => "check"],
                    ["subtarea" => "Placa Furgón",  "texto_ayuda" => "Revise si la placa del furgón es el correcto", "inputType" => "check"],
                    ["subtarea" => "Numero Economico",  "texto_ayuda" => "Ingrese el numero económico de la unidad", "inputType" => "text"],
                    ["subtarea" => "Sellos",  "texto_ayuda" => "Ingrese los sellos", "inputType" => "text"],
                    ["subtarea" => "Peso total", "texto_ayuda" => "Ingrese el peso total de la mercancia según la documentación", "inputType" => "text"],
                    ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Ingrese la cantidad de bultos según la documentación", "inputType" => "text"],
                    ["subtarea" => "Nombre de planta", "texto_ayuda" => "Ingrese el nombre de la planta donde proviene la mercancia (No es obligatorio)", "inputType" => "text", "required" => 0],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Anexos fotograficos",
                    "titulo_largo" => "Revisión de la unidad y anexos fotograficos",
                    "avance" => 5,
                    "icono" => "fa fa-camera",
                ],
                "subtareas" => [
                    ["subtarea" => "Placa cabezal", "texto_ayuda" => "Capture una foto de la placa del cabezal",  "inputType" => "photos"],        
                    ["subtarea" => "Placa furgón", "texto_ayuda" => "Capture una foto de la placa del furgón",  "inputType" => "photos"],        
                    ["subtarea" => "Numero económico", "texto_ayuda" => "Capture una foto del numero economico",  "inputType" => "photos"],        
                    ["subtarea" => "Sellos", "texto_ayuda" => "Capture fotos de los sellos",  "inputType" => "photos", "limit" => 3],        
                ]

            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación",
                    "titulo_largo" => "Previa validación de la descarga",
                    "avance" => 5,
                    "icono" => "fa fa-check",
                ],
                "subtareas" => [
                    ["subtarea" => "Enviar a validación", "texto_ayuda" => "De click al botón para enviarlo a validción",  "inputType" => "button-validation"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Fuerza de tarea",
                    "titulo_largo" => "Selleción y activación de la fuerza de tarea",
                    "avance" => 5,
                    "icono" => "fa fa-users",
                ],
                "subtareas" => [
                    ["subtarea" => "Fuerza de tarea", "texto_ayuda" => "Seleccione la fuerza de tarea",  "inputType" => "component-fuerzatarea"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Proceso de maniobra",
                    "titulo_largo" => "Proceso de supervisión y verificación de mercancia",
                    "avance" => 70,
                    "icono" => "fa fa-cog",
                ],
                "subtareas" => [
                    ["subtarea" => "Foto inicial", "texto_ayuda" => "Capture la foto inicial",  "inputType" => "photos"],
                    ["subtarea" => "Numero de gatas", "texto_ayuda" => "Inserte el numero de gatas",  "inputType" => "number"],
                    ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Inserte la cantidad de bultos",  "inputType" => "number"],
                    ["subtarea" => "Fotos del proceso de descarga", "texto_ayuda" => "Inserte las fotos del proceso de descarga",  "inputType" => "photos", "limit" => 15],
                    ["subtarea" => "Observaciones de la mercancia", "texto_ayuda" => "Escriba las observaciones de la mercancia",  "inputType" => "textarea"],
                    ["subtarea" => "Evidencia de irregularidades", "texto_ayuda" => "Encaso de que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                    ["subtarea" => "Ubicacion de la mercancia", "texto_ayuda" => "Escriba con detalle la ubicación dónde quedara hubicada la mercancia dentro del almacén",  "inputType" => "photos", "limit"=> 15],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación",
                    "titulo_largo" => "Validación y almacenamiento de la descarga",
                    "avance" => 5,
                    "icono" => "fa fa-check",
                ],
                "subtareas" => [
                    ["subtarea" => "Enviar a validación", "texto_ayuda" => "De click al botón para enviarlo a validción",  "inputType" => "button-validation"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Finalización",
                    "titulo_largo" => "Cierre de la maniobra",
                    "avance" => 5,
                    "icono" => "fa fa-flag-checkered",
                ],
                "subtareas" => [
                    ["subtarea" => "Firma del operador", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Firma del supervisor", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Imprimir documentación", "texto_ayuda" => "",  "inputType" => "button-imprimir"],
                ]
            ],
        ];
    }

    public function tareasCarga($coordinacion_id)
    {
       
        return [
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Revisión",
                    "titulo_largo" => "Recepción y revisión de ordenes",
                    "avance" => 5,
                    "icono" => "fa fa-search",
                ],
                "subtareas" =>  [
                    ["subtarea" => "Documentación", "texto_ayuda" => "Asegurese de contar con la documentación correcta y completa",  "inputType" => "check"],
                    ["subtarea" => "Nombre del perador", "texto_ayuda" => "Comprube si el operador de la unidad se identifica con el nombre correcto", "inputType" => "check"],
                    ["subtarea" => "Placa cabezal", "texto_ayuda" => "Revise si la placa del cabezal es la correcta",  "inputType" => "check"],
                    ["subtarea" => "Placa Furgón",  "texto_ayuda" => "Revise si la placa del furgón es el correcto", "inputType" => "check"],
                    ["subtarea" => "Numero Economico",  "texto_ayuda" => "Ingrese el numero económico de la unidad", "inputType" => "text"],
                    ["subtarea" => "Sellos",  "texto_ayuda" => "Ingrese los sellos", "inputType" => "text"],
                    ["subtarea" => "Peso total", "texto_ayuda" => "Ingrese el peso total de la mercancia según la documentación", "inputType" => "text"],
                    ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Ingrese la cantidad de bultos según la documentación", "inputType" => "text"],
                    ["subtarea" => "Nombre de planta", "texto_ayuda" => "Ingrese el nombre de la planta donde proviene la mercancia (No es obligatorio)", "inputType" => "text", "required" => 0],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Anexos fotograficos",
                    "titulo_largo" => "Revisión de la unidad y anexos fotograficos",
                    "avance" => 5,
                    "icono" => "fa fa-camera",
                ],
                "subtareas" => [
                    ["subtarea" => "Placa cabezal", "texto_ayuda" => "Capture una foto de la placa del cabezal",  "inputType" => "photos"],        
                    ["subtarea" => "Placa furgón", "texto_ayuda" => "Capture una foto de la placa del furgón",  "inputType" => "photos"],        
                    ["subtarea" => "Numero económico", "texto_ayuda" => "Capture una foto del numero economico",  "inputType" => "photos"],        
                    ["subtarea" => "Sellos", "texto_ayuda" => "Capture fotos de los sellos",  "inputType" => "photos", "limit" => 3],        
                ]

            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación",
                    "titulo_largo" => "Previa validación de la descarga",
                    "avance" => 5,
                    "icono" => "fa fa-check",
                ],
                "subtareas" => [
                    ["subtarea" => "Enviar a validación", "texto_ayuda" => "De click al botón para enviarlo a validción",  "inputType" => "button-validation"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Fuerza de tarea",
                    "titulo_largo" => "Selleción y activación de la fuerza de tarea",
                    "avance" => 5,
                    "icono" => "fa fa-users",
                ],
                "subtareas" => [
                    ["subtarea" => "Fuerza de tarea", "texto_ayuda" => "Seleccione la fuerza de tarea",  "inputType" => "component-fuerzatarea"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Proceso de maniobra",
                    "titulo_largo" => "Proceso de supervisión y verificación de mercancia",
                    "avance" => 70,
                    "icono" => "fa fa-cog",
                ],
                "subtareas" => [
                    ["subtarea" => "Foto inicial", "texto_ayuda" => "Capture la foto inicial",  "inputType" => "photos"],
                    ["subtarea" => "Numero de gatas", "texto_ayuda" => "Inserte el numero de gatas",  "inputType" => "number"],
                    ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Inserte la cantidad de bultos",  "inputType" => "number"],
                    ["subtarea" => "Fotos del proceso de descarga", "texto_ayuda" => "Inserte las fotos del proceso de descarga",  "inputType" => "photos", "limit"=>15 ],
                    ["subtarea" => "Observaciones de la mercancia", "texto_ayuda" => "Escriba las observaciones de la mercancia",  "inputType" => "textarea"],
                    ["subtarea" => "Evidencia de irregularidades", "texto_ayuda" => "Encaso de que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit" => 15 ,"required" => 0 ],
                    ["subtarea" => "Ubicacion de la mercancia", "texto_ayuda" => "Escriba con detalle la ubicación dónde quedara hubicada la mercancia dentro del almacén",  "inputType" => "textarea"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación",
                    "titulo_largo" => "Validación y almacenamiento de la descarga",
                    "avance" => 5,
                    "icono" => "fa fa-check",
                ],
                "subtareas" => [
                    ["subtarea" => "Enviar a validación", "texto_ayuda" => "De click al botón para enviarlo a validción",  "inputType" => "button-validation"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Finalización",
                    "titulo_largo" => "Cierre de la maniobra",
                    "avance" => 5,
                    "icono" => "fa fa-flag-checkered",
                ],
                "subtareas" => [
                    ["subtarea" => "Firma del operador", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Firma del supervisor", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Imprimir documentación", "texto_ayuda" => "",  "inputType" => "button-imprimir"],
                ]
            ],
        ];
    }

}
