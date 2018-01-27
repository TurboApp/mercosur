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
        if($this->tipo==='Trasbordo'){
            $taks = $this->tareasTrasbordo($coordinacion_id);
            for($i = 0; $i < count($taks); $i++)
            {
                $tarea = ManiobraTarea::create( $taks[$i]["tarea"] );
                if(isset($taks[$i]["subtareas"]["NACIONAL"]))
                {
                    for($x = 0 ; $x < count($taks[$i]["subtareas"]["NACIONAL"]); $x++)
                    {
                        ManiobraSubtarea::create( ["tarea_id" => $tarea->id] +  $taks[$i]["subtareas"]["NACIONAL"][$x] + ["tipo_transporte" => 'N'] );
                    }
                    for($x = 0 ; $x < count($taks[$i]["subtareas"]["CENTROAMERICANO"]); $x++)
                    {
                        ManiobraSubtarea::create( ["tarea_id" => $tarea->id] +  $taks[$i]["subtareas"]["CENTROAMERICANO"][$x] + ["tipo_transporte" => 'C'] );
                    }
                }
                else{
                    for($x = 0 ; $x < count($taks[$i]["subtareas"]); $x++)
                    {
                        ManiobraSubtarea::create( ["tarea_id" => $tarea->id] +  $taks[$i]["subtareas"][$x] );
                    }
                }    
            }
        }
        else
        {
            if($this->tipo==='Descarga')
            {
                $taks = $this->tareasDescarga($coordinacion_id);
            }
            else{
                $taks = $this->tareasCarga($coordinacion_id);
            }

            for($i = 0; $i < count($taks); $i++)
            {
                $tarea = ManiobraTarea::create( $taks[$i]["tarea"] );
                for($x = 0 ; $x < count($taks[$i]["subtareas"]); $x++)
                {
                    ManiobraSubtarea::create( ["tarea_id" => $tarea->id] +  $taks[$i]["subtareas"][$x] );
                }
                
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
                    "titulo_corto" => "Recepción",
                    "titulo_largo" => "Recepción y revisión de ordenes",
                    "avance" => 5,
                    "icono" => "fa fa-file-text-o",
                ],
                "subtareas" =>  [
                    ["subtarea" => "¿Cuenta con documentación correcta y completa?", "texto_ayuda" => "",  "inputType" => "check"],
                    ["subtarea" => "¿El nombre del operador es correcto?", "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "¿La placa del cabezal es la indicada?", "texto_ayuda" => "",  "inputType" => "check"],
                    ["subtarea" => "¿La placa del furgón es correcta?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "Por favor, ingrese el numero económico de la unidad",  "texto_ayuda" => "Numero economico", "inputType" => "number"],
                    ["subtarea" => "Nombre de planta", "texto_ayuda" => "Ingrese el nombre de la planta donde proviene la mercancia (No es obligatorio)", "inputType" => "text", "required" => 0],
                    ["subtarea" => "Capture las fotos de la placa del cabezal", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    ["subtarea" => "Capture las fotos de la placa del furgón", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    ["subtarea" => "Ingrese los sellos",  "texto_ayuda" => "Puede separar los sellos con comas", "inputType" => "text"],
                    ["subtarea" => "Capture fotos de los sellos", "texto_ayuda" => "",  "inputType" => "photos", "limit" => 5],        
                    ["subtarea" => "Ingrese el peso total de la mercancia", "texto_ayuda" => "", "inputType" => "text"],
                    ["subtarea" => "Ingrese la cantidad de bultos", "texto_ayuda" => "", "inputType" => "text"],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Revisión",
                    "titulo_largo" => "Revisión de la unidad",
                    "avance" => 5,
                    "icono" => "fa fa-search",
                ],
                "subtareas" => [
                    ["subtarea" => "Indique el estado de la plataforma / caja", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo, Regular"],        
                    ["subtarea" => "Seleccione el estado de las llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                    ["subtarea" => "Indique el estado de la  presion de llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                    ["subtarea" => "¿Las llantas cuentan con sus tuercas completas?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "¿La unidad cuenta con llantas de repuesto?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "¿La unidad cuenta con herramientas y señales reflejantes?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "¿La unidad cuenta con lonas en buen estado?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "¿La cantidad de lonas es la adecuada?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "¿La unidad cuenta con herramientas para ajustar?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "Ingrese el tipo de herramientas para ajustar con que cuenta la unidad",  "texto_ayuda" => "", "inputType" => "text"],
                    ["subtarea" => "¿Las luces indicadoras funcionan adecuadamente?",  "texto_ayuda" => "", "inputType" => "check"],
                    ["subtarea" => "Escriba las observaciones generales de la plataforma", "texto_ayuda" => "",  "inputType" => "textarea"],        
                ]

            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación Previa",
                    "titulo_largo" => "Previa validación de la descarga",
                    "avance" => 5,
                    "icono" => "fa fa-check",
                ],
                "subtareas" => [
                    ["subtarea" => "Validar", "texto_ayuda" => "De click al botón para enviarlo a validación",  "inputType" => "button-validation"],
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
                    ["subtarea" => "Capture la foto inicial", "texto_ayuda" => "",  "inputType" => "photos"],
                    ["subtarea" => "Ingrese el numero de gatas que tiene la unidad", "texto_ayuda" => "",  "inputType" => "number"],
                    ["subtarea" => "Ingrese la cantidad de bultos", "texto_ayuda" => "",  "inputType" => "number"],
                    ["subtarea" => "Capture las  fotos del proceso de descarga", "texto_ayuda" => "",  "inputType" => "photos", "limit" => 20],
                    ["subtarea" => "Escriba las observaciones de la mercancia", "texto_ayuda" => "",  "inputType" => "textarea"],
                    ["subtarea" => "Capture fotos de evidencia de irregularidades", "texto_ayuda" => "En caso que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                    ["subtarea" => "Capture las fotos donde fue ubicada la mercancia", "texto_ayuda" => "",  "inputType" => "photos", "limit"=> 20],
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
                ]
            ]
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

    public function tareasTrasbordo($coordinacion_id)
    {
        return [
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Revisión",
                    "titulo_largo" => "Recepción y revisión de ordenes",
                    "avance" => 5,
                    "icono" => "fa fa-search",
                    "tipo" => "doble"
                    
                ],
                "subtareas" =>  [
                    "NACIONAL" => [
                        ["subtarea" => "Documentación", "texto_ayuda" => "Asegurese de contar con la documentación correcta y completa",  "inputType" => "check"],
                        ["subtarea" => "Nombre del perador", "texto_ayuda" => "Comprube si el operador de la unidad se identifica con el nombre correcto", "inputType" => "check"],
                        ["subtarea" => "Placa cabezal", "texto_ayuda" => "Revise si la placa del cabezal es la correcta",  "inputType" => "check"],
                        ["subtarea" => "Placa Furgón",  "texto_ayuda" => "Revise si la placa del furgón es el correcto", "inputType" => "check"],
                        ["subtarea" => "Numero Economico",  "texto_ayuda" => "Ingrese el numero económico de la unidad", "inputType" => "text"],
                        ["subtarea" => "Sellos",  "texto_ayuda" => "Ingrese los sellos", "inputType" => "text"],
                        ["subtarea" => "Peso total", "texto_ayuda" => "Ingrese el peso total de la mercancia según la documentación", "inputType" => "text"],
                        ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Ingrese la cantidad de bultos según la documentación", "inputType" => "text"],
                        ["subtarea" => "Nombre de planta", "texto_ayuda" => "Ingrese el nombre de la planta donde proviene la mercancia (No es obligatorio)", "inputType" => "text", "required" => 0],
                    ],
                    "CENTROAMERICANO" => [
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
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Anexos fotograficos",
                    "titulo_largo" => "Revisión de la unidad y anexos fotograficos",
                    "avance" => 5,
                    "icono" => "fa fa-camera",
                    "tipo" => "doble"
                ],
                "subtareas" => [
                    "NACIONAL" => [
                        ["subtarea" => "Placa cabezal", "texto_ayuda" => "Capture una foto de la placa del cabezal",  "inputType" => "photos"],        
                        ["subtarea" => "Placa furgón", "texto_ayuda" => "Capture una foto de la placa del furgón",  "inputType" => "photos"],        
                        ["subtarea" => "Numero económico", "texto_ayuda" => "Capture una foto del numero economico",  "inputType" => "photos"],        
                        ["subtarea" => "Sellos", "texto_ayuda" => "Capture fotos de los sellos",  "inputType" => "photos", "limit" => 3],        
                    ],
                    "CENTROAMERICANO" => [
                        ["subtarea" => "Placa cabezal", "texto_ayuda" => "Capture una foto de la placa del cabezal",  "inputType" => "photos"],        
                        ["subtarea" => "Placa furgón", "texto_ayuda" => "Capture una foto de la placa del furgón",  "inputType" => "photos"],        
                        ["subtarea" => "Numero económico", "texto_ayuda" => "Capture una foto del numero economico",  "inputType" => "photos"],        
                        ["subtarea" => "Sellos", "texto_ayuda" => "Capture fotos de los sellos",  "inputType" => "photos", "limit" => 3],        
                    ]
                ]

            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación Previa",
                    "titulo_largo" => "Previa validación de la descarga",
                    "avance" => 5,
                    "icono" => "fa fa-check",
                ],
                "subtareas" => [
                    ["subtarea" => "Validar", "texto_ayuda" => "De click al botón para enviarlo a validación",  "inputType" => "button-validation"],
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
                    "tipo" => "doble"
                ],
                "subtareas" => [
                    "NACIONAL" => [
                        ["subtarea" => "Foto inicial", "texto_ayuda" => "Capture la foto inicial",  "inputType" => "photos"],
                        ["subtarea" => "Numero de gatas", "texto_ayuda" => "Inserte el numero de gatas",  "inputType" => "number"],
                        ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Inserte la cantidad de bultos",  "inputType" => "number"],
                        ["subtarea" => "Fotos del proceso de descarga", "texto_ayuda" => "Inserte las fotos del proceso de descarga",  "inputType" => "photos", "limit" => 15],
                        ["subtarea" => "Observaciones de la mercancia", "texto_ayuda" => "Escriba las observaciones de la mercancia",  "inputType" => "textarea"],
                        ["subtarea" => "Evidencia de irregularidades", "texto_ayuda" => "Encaso de que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                        ["subtarea" => "Ubicacion de la mercancia", "texto_ayuda" => "Escriba con detalle la ubicación dónde quedara hubicada la mercancia dentro del almacén",  "inputType" => "photos", "limit"=> 15],
                    ],
                    "CENTROAMERICANO" => [
                        ["subtarea" => "Foto inicial", "texto_ayuda" => "Capture la foto inicial",  "inputType" => "photos"],
                        ["subtarea" => "Numero de gatas", "texto_ayuda" => "Inserte el numero de gatas",  "inputType" => "number"],
                        ["subtarea" => "Cantidad de bultos", "texto_ayuda" => "Inserte la cantidad de bultos",  "inputType" => "number"],
                        ["subtarea" => "Fotos del proceso de descarga", "texto_ayuda" => "Inserte las fotos del proceso de descarga",  "inputType" => "photos", "limit" => 15],
                        ["subtarea" => "Observaciones de la mercancia", "texto_ayuda" => "Escriba las observaciones de la mercancia",  "inputType" => "textarea"],
                        ["subtarea" => "Evidencia de irregularidades", "texto_ayuda" => "Encaso de que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                        ["subtarea" => "Ubicacion de la mercancia", "texto_ayuda" => "Escriba con detalle la ubicación dónde quedara hubicada la mercancia dentro del almacén",  "inputType" => "photos", "limit"=> 15],
                    ]
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
                    ["subtarea" => "Firma del operador Nacional", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Firma del operador Centroamericano", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Firma del supervisor", "texto_ayuda" => "",  "inputType" => "draw"],
                    ["subtarea" => "Imprimir documentación", "texto_ayuda" => "",  "inputType" => "button-imprimir"],
                ]
            ],
        ];
    }
}
