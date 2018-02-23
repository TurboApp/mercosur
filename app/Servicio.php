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
        $date = str_replace( '/', '-', $fecha);
        $date = date( 'Y-m-d' , strtotime($date) );
        //$coordinacion = Coordinacion::whereDate( 'created_at', $date )->orderBy('turno','desc')->first();
        $equipoID = auth()->user()->equipo_id;
        $coordinacion = Coordinacion::whereDate( 'created_at', $date )
                    ->whereHas('servicio.autor', function($q) use ($equipoID){
                        $q->where('equipo_id', $equipoID );
                    })
                    ->orderBy('turno','desc')->first();
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
                    //1.- Documentación
                    ["subtarea" => "¿Cuenta con documentación correcta y completa?", "texto_ayuda" => "",  "inputType" => "check"],
                    //2.- Nombre del operador
                    ["subtarea" => "¿El nombre del operador es correcto?", "texto_ayuda" => "", "inputType" => "check"],
                    //3.- Placa cabezal
                    ["subtarea" => "¿La placa del cabezal es la indicada?", "texto_ayuda" => "",  "inputType" => "check"],
                    //4.- Toma de foto de placa cabezal
                    ["subtarea" => "Capture las fotos de la placa del cabezal", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    //5.- Placa furgon
                    ["subtarea" => "¿La placa del furgón es correcta?",  "texto_ayuda" => "", "inputType" => "check"],
                    //6.- Toma de foto de placa del furgón
                    ["subtarea" => "Capture las fotos de la placa del furgón", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    //7.- Numero economico
                    ["subtarea" => "Por favor, ingrese el numero económico de la unidad",  "texto_ayuda" => "Numero economico", "inputType" => "text"],
                    //8.- Toma de foto del numero economico
                    ["subtarea" => "Capture las fotos del numero econocmico", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    //9.- Planta donde proviene el producto
                    ["subtarea" => "Planta donde proviene el producto (opcional)", "texto_ayuda" => "Ingrese el nombre de la planta donde proviene la mercancia", "inputType" => "text", "required" => 0],
                    //10.- Ingeso de sellos
                    ["subtarea" => "Ingrese los sellos",  "texto_ayuda" => "Puede separar los sellos con comas", "inputType" => "text"],
                    //11.- Toma de fotos de sellos
                    ["subtarea" => "Antes de retirar los sellos tome unas fotografias", "texto_ayuda" => "",  "inputType" => "photos", "limit" => 12],        
                    //12.- Peso total
                    ["subtarea" => "Ingrese el peso total de la mercancia de acuerdo a la documentación", "texto_ayuda" => "", "inputType" => "text"],
                    //13.- Cantidad de bultos
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
                    //1.- Estado de la plataforma / caja
                    ["subtarea" => "Indique el estado de la plataforma / caja", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo, Regular"],        
                    //2.- Llantas en buen estado
                    ["subtarea" => "Seleccione el estado de las llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                    //3.- Presión de las llantas
                    ["subtarea" => "Indique el estado de la  presion de llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                    //4.- Tuercas completas
                    ["subtarea" => "¿Las llantas cuentan con sus tuercas completas?",  "texto_ayuda" => "", "inputType" => "check"],
                    //5.- Llantas de repuesto
                    ["subtarea" => "¿La unidad cuenta con llantas de repuesto?",  "texto_ayuda" => "", "inputType" => "check"],
                    //6.- Herramientas y señales reflejantes
                    ["subtarea" => "¿La unidad cuenta con herramientas y señales reflejantes?",  "texto_ayuda" => "", "inputType" => "check"],
                    //7.- Lonas en buen estado
                    ["subtarea" => "¿La unidad cuenta con lonas en buen estado?",  "texto_ayuda" => "", "inputType" => "check"],
                    //8.- Cantidad de lonas adecuadas
                    ["subtarea" => "¿La cantidad de lonas es la adecuada?",  "texto_ayuda" => "", "inputType" => "check"],
                    //9.- Herramientas para ajustar
                    ["subtarea" => "¿La unidad cuenta con herramientas para ajustar?",  "texto_ayuda" => "", "inputType" => "check"],
                    //10.- Tipo de herramientas para ajustar
                    ["subtarea" => "Ingrese el tipo de herramientas para ajustar con que cuenta la unidad",  "texto_ayuda" => "Ejemplo: Cadenas, Lazos, Slingas, Fajas ... Etc. ", "inputType" => "text"],
                    //11.- Funcionamiento de luces indicadoras
                    ["subtarea" => "¿Las luces indicadoras funcionan adecuadamente?",  "texto_ayuda" => "", "inputType" => "check"],
                    //12.- Observaciones generales de la plataforma o caja
                    ["subtarea" => "Escriba las observaciones generales de la plataforma o caja", "texto_ayuda" => "",  "inputType" => "textarea"],        
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
                    "titulo_largo" => "Seleción y activación de la fuerza de tarea",
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
                    //1.- Tomar foto inicial
                    ["subtarea" => "Capture la foto inicial", "texto_ayuda" => "",  "inputType" => "photos"],
                    //2.- Numero de gatas
                    ["subtarea" => "Ingrese el numero de gatas que tiene la unidad", "texto_ayuda" => "",  "inputType" => "number"],
                    //3.- Foto de proceso de descarga
                    ["subtarea" => "Capture las fotos del proceso de descarga", "texto_ayuda" => "Capture las fotos necesarias",  "inputType" => "photos", "limit" => 99],
                    //4.- Observaciones de mercancia
                    ["subtarea" => "Escriba las observaciones de la mercancia", "texto_ayuda" => "",  "inputType" => "textarea"],
                    //5.- Evidencia de irregularidades
                    ["subtarea" => "Capture fotos de evidencia de irregularidades", "texto_ayuda" => "En caso que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                    //6.- Ubicacion de mercancia
                    ["subtarea" => "Capture las fotos donde fue ubicada la mercancia", "texto_ayuda" => "",  "inputType" => "photos", "limit"=> 20],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación",
                    "titulo_largo" => "Validación del proceso de descarga",
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
                    ["subtarea" => "Entrega de documentación", "texto_ayuda" => "La documentación sera entregada en la recepción de docuemntos (Trafico)",  "inputType" => "aviso", "options" => "info"],
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
                    "titulo_corto" => "Recepción",
                    "titulo_largo" => "Recepción y revisión de ordenes",
                    "avance" => 5,
                    "icono" => "fa fa-file-text-o",
                ],
                "subtareas" =>  [
                    // 1.- Documentación - checbox
                    ["subtarea" => "¿Cuenta con documentación correcta y completa?", "texto_ayuda" => "",  "inputType" => "check"],
                    // 2.- Nombre del operador - Texto
                    ["subtarea" => "¿El nombre del operador es correcto?", "texto_ayuda" => "", "inputType" => "check"],
                    // 3.- Placa cabezal - Checkbox
                    ["subtarea" => "¿La placa del cabezal es la indicada?", "texto_ayuda" => "",  "inputType" => "check"],
                    // 4.- Toma de foto de placa de cabezal - fotos(2)
                    ["subtarea" => "Capture las fotos de la placa del cabezal", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    // 5.- Placa furgon - Checkbox
                    ["subtarea" => "¿La placa del furgón es correcta?",  "texto_ayuda" => "", "inputType" => "check"],
                    // 6.- Toma de fotos de placa de furgón - Fotos(3)
                    ["subtarea" => "Capture las fotos de la placa del furgón", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    // 7.- Numero economico - Texto
                    ["subtarea" => "Por favor, ingrese el numero económico de la unidad",  "texto_ayuda" => "Numero economico", "inputType" => "number"],
                    // 8.- Toma de foto de numero economico - Fotos(2)
                    ["subtarea" => "Capture las fotos del numero economico", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                    // 9.- Medidda de caja 56 o 43 - select
                    ["subtarea" => "Seleccione la medida de la caja", "texto_ayuda" => "",  "inputType" => "select", "options"=>"43'', 56''"],        
                    // 10.- Ubicacion de la mercancia - checkbox
                    ["subtarea" => "¿La mercancia ya fue ubicada?", "texto_ayuda" => "",  "inputType" => "check"],
                    // 11.- Cantidad de bultos - checkbox
                    ["subtarea" => "Ingrese la cantidad de bultos de acuerdo a la documentación", "texto_ayuda" => "",  "inputType" => "check"],
                    // 12.- Peso Total - text
                    ["subtarea" => "Ingrese el peso total de acuerdo a la documentación", "texto_ayuda" => "", "inputType" => "text"],
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
                    //1.- Estado de la plataforma / caja - select[Bueno, Malo, Regular]
                    ["subtarea" => "Indique el estado de la plataforma / caja", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo, Regular"],        
                    //2.- Llantas en buen estado - select[Bueno. Malo]
                    ["subtarea" => "Seleccione el estado de las llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                    //3.- Presion de llantas - Select[Bueno, Malo]
                    ["subtarea" => "Indique el estado de la  presion de llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                    //4.- Tuercas completas - Checkbox
                    ["subtarea" => "¿Las llantas cuentan con sus tuercas completas?",  "texto_ayuda" => "", "inputType" => "check"],
                    //5.- Llantas de repuesto - Checkbox
                    ["subtarea" => "¿La unidad cuenta con llantas de repuesto?",  "texto_ayuda" => "", "inputType" => "check"],
                    //6.- Herramientas y señales reflejantes - Checkbox
                    ["subtarea" => "¿La unidad cuenta con herramientas y señales reflejantes?",  "texto_ayuda" => "", "inputType" => "check"],
                    //7.- Lonas en buen estado - checkbox
                    ["subtarea" => "¿La unidad cuenta con lonas en buen estado?",  "texto_ayuda" => "", "inputType" => "check"],
                    //8.- Cantidad de lonas adecuadas - checkbox
                    ["subtarea" => "¿La cantidad de lonas es la adecuada?",  "texto_ayuda" => "", "inputType" => "check"],
                    //9.- Herramientas para ajustar - checkbox
                    ["subtarea" => "¿La unidad cuenta con herramientas para ajustar?",  "texto_ayuda" => "", "inputType" => "check"],
                    //10.- Tipo de herramientas para ajustar - texto
                    ["subtarea" => "Ingrese el tipo de herramientas para ajustar con que cuenta la unidad",  "texto_ayuda" => "Ejemplo: Cadenas, Lazos, Slingas, Fajas ... Etc. ", "inputType" => "text"],
                    //11.- Funcionamiento de luces indicadoras - checkbox
                    ["subtarea" => "¿Las luces indicadoras funcionan adecuadamente?",  "texto_ayuda" => "", "inputType" => "check"],
                    //12.- Observaciones generales de la plataforma o caja - textArea
                    ["subtarea" => "Escriba las observaciones generales de la plataforma o caja", "texto_ayuda" => "",  "inputType" => "textarea"],        
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
                    //1.- Foto inicial - foto
                    ["subtarea" => "Capture la foto inicial", "texto_ayuda" => "",  "inputType" => "photos"],
                    //2.- Fotos de proceso de carga
                    ["subtarea" => "Capture las  fotos del proceso de carga", "texto_ayuda" => "Capture las fotos necesarias",  "inputType" => "photos", "limit" => 99],
                    //3.- Observaciones de la mercancia
                    ["subtarea" => "Escriba las observaciones de la mercancia", "texto_ayuda" => "",  "inputType" => "textarea"],
                    //4.- Evidencia de irregularidades
                    ["subtarea" => "Capture fotos de evidencia de irregularidades", "texto_ayuda" => "En caso que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación",
                    "titulo_largo" => "Validación del proceso de carga",
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
                    //1.- Colocacion de sellos - text
                    ["subtarea" => "Ingrese los sellos que se colocaran en la plataforma / caja",  "texto_ayuda" => "Puede separar los sellos con comas", "inputType" => "text"],
                    //2.- Toma de los fotografias de sellos puestos
                    ["subtarea" => "Capture fotos de los sellos puestos", "texto_ayuda" => "",  "inputType" => "photos", "limit" => 5],        
                    //3.- Firma del operador
                    ["subtarea" => "Firma del operador", "texto_ayuda" => "",  "inputType" => "draw"],
                    //4.- Firma del supervisor
                    ["subtarea" => "Firma del supervisor", "texto_ayuda" => "",  "inputType" => "draw"],
                    //5.- Entrega de documentos
                    ["subtarea" => "Entrega de documentación", "texto_ayuda" => "La documentación sera entregada en la recepción de docuemntos (Trafico)",  "inputType" => "aviso", "options" => "info"],

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
                    "titulo_corto" => "Recepción",
                    "titulo_largo" => "Recepción y revisión de ordenes",
                    "avance" => 5,
                    "icono" => "fa fa-file-text-o",
                    "tipo" => "doble"
                ],
                "subtareas" =>  [
                    "NACIONAL" => [
                        // 1.- Documentacion	
                        ["subtarea" => "¿Cuenta con documentación correcta y completa?", "texto_ayuda" => "",  "inputType" => "check"],
                        // 2.- Nombre del operador	
                        ["subtarea" => "¿El nombre del operador es correcto?", "texto_ayuda" => "", "inputType" => "check"],
                        // 3.- Placa cabezal	
                        ["subtarea" => "¿La placa del cabezal es la indicada?", "texto_ayuda" => "",  "inputType" => "check"],
                        // 4.- Toma de foto de placa del cabezal	Fotos (2)
                        ["subtarea" => "Capture las fotos de la placa del cabezal", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                        // 5.- Placa Furgon	
                        ["subtarea" => "¿La placa del furgón es correcta?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 6.- Toma de foto de placas del furgon	Fotos (2)
                        ["subtarea" => "Capture las fotos de la placa del furgón", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                        // 7.- Numero economico	
                        ["subtarea" => "Por favor, ingrese el numero económico de la unidad",  "texto_ayuda" => "Numero economico", "inputType" => "number"],
                        // 8.- Toma de foto del numero economico
                        ["subtarea" => "Capture las fotos del numero econocmico", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                        // 9.- Planta donde proviene el producto	
                        ["subtarea" => "Planta donde proviene el producto", "texto_ayuda" => "Ingrese el nombre de la planta donde proviene la mercancia (opcional)", "inputType" => "text", "required" => 0],
                        // 10.- ingresa los sellos	
                        ["subtarea" => "Ingrese los sellos",  "texto_ayuda" => "Puede separar los sellos con comas", "inputType" => "text"],
                        // 11.- Foto de Sellos	Fotos(3)
                        ["subtarea" => "Capture fotos de los sellos", "texto_ayuda" => "",  "inputType" => "photos", "limit" => 5],        
                        // 12.- Peso total	
                        ["subtarea" => "Ingrese el peso total de la mercancia", "texto_ayuda" => "", "inputType" => "text"],
                        // 13.- Cantidad de bultos	
                        ["subtarea" => "Ingrese la cantidad de bultos", "texto_ayuda" => "", "inputType" => "text"],
                    ],
                    "CENTROAMERICANO" => [
                        // 1.- Documentacion
                        ["subtarea" => "¿Cuenta con documentación correcta y completa?", "texto_ayuda" => "",  "inputType" => "check"],	
                        // 2.- Nombre del operador	
                        ["subtarea" => "¿El nombre del operador es correcto?", "texto_ayuda" => "", "inputType" => "check"],
                        // 3.- Placa del cabezal	
                        ["subtarea" => "¿La placa del cabezal es la indicada?", "texto_ayuda" => "",  "inputType" => "check"],
                        // 4.- Tomo de foto de placa de cabezal	
                        ["subtarea" => "Capture las fotos de la placa del cabezal", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                        // 5.- Placa Furgon	
                        ["subtarea" => "¿La placa del furgón es correcta?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 6.- Toma de foto de placas del furgon	Fotos (2)
                        ["subtarea" => "Capture las fotos de la placa del furgón", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                        // 7.- Numero economico	
                        ["subtarea" => "Por favor, ingrese el numero económico de la unidad",  "texto_ayuda" => "Numero economico", "inputType" => "number"],
                        // 8.- Toma de foto numero economico	
                        ["subtarea" => "Capture las fotos del numero economico", "texto_ayuda" => "Como maximo deben ser dos",  "inputType" => "photos", "limit" => 2],        
                        // 9.- Medida de Caja 56 o 43"	Fotos(3)
                        ["subtarea" => "Capture las fotos de la medida de la caja 56' o 43'", "texto_ayuda" => "Como maximo deben ser tres",  "inputType" => "photos", "limit" => 3],        
                        // 10.- Cantidad de bultos	
                        ["subtarea" => "Ingrese la cantidad de bultos", "texto_ayuda" => "",  "inputType" => "text"],
                        // 11.- Peso total	Fotos (2)
                        ["subtarea" => "Ingrese el peso total de la mercancia", "texto_ayuda" => "", "inputType" => "text"],

                    ]
                ]
            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Revisión",
                    "titulo_largo" => "Revisión de la unidad",
                    "avance" => 5,
                    "icono" => "fa fa-search",
                    "tipo" => "doble"
                ],
                "subtareas" => [
                    "NACIONAL" => [
                        // 1.- Estado de la plataforma / caja
                        ["subtarea" => "Indique el estado de la plataforma / caja", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo, Regular"],        
                        // 2.- Llantas en buen estado
                        ["subtarea" => "Seleccione el estado de las llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                        // 3.- Presion de las llantas
                        ["subtarea" => "Indique el estado de la  presion de llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                        // 4.- Tuercas completas
                        ["subtarea" => "¿Las llantas cuentan con sus tuercas completas?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 5.- Llantas de repuesto
                        ["subtarea" => "¿La unidad cuenta con llantas de repuesto?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 6.- Herramientas y señales reflejantes
                        ["subtarea" => "¿La unidad cuenta con herramientas y señales reflejantes?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 7.- Lonas en buen estado
                        ["subtarea" => "¿La unidad cuenta con lonas en buen estado?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 8.- Cantidad de lonas adecuada
                        ["subtarea" => "¿La cantidad de lonas es la adecuada?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 9.- Herramientas para ajustar
                        ["subtarea" => "¿La unidad cuenta con herramientas para ajustar?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 10.- Tipo de herramienta de ajustar
                        ["subtarea" => "Ingrese el tipo de herramientas para ajustar con que cuenta la unidad",  "texto_ayuda" => "Ejemplo: Cadenas, Lazos, Slingas, Fajas ... Etc. ", "inputType" => "text"],
                        // 11.- Funcionamiento de luces indicadoras
                        ["subtarea" => "¿Las luces indicadoras funcionan adecuadamente?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 12.- Observaciones generales de la plataforma o caja
                        ["subtarea" => "Escriba las observaciones generales de la plataforma o caja", "texto_ayuda" => "",  "inputType" => "textarea"],        
                    ],
                    "CENTROAMERICANO" => [
                        // 1.- Estado de la plataforma / caja
                        ["subtarea" => "Indique el estado de la plataforma / caja", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo, Regular"],        
                        // 2.- Llantas en buen estado
                        ["subtarea" => "Seleccione el estado de las llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                        // 3.- Presion de las llantas
                        ["subtarea" => "Indique el estado de la  presion de llantas", "texto_ayuda" => "",  "inputType" => "select", "options"=>"Bueno, Malo"],        
                        // 4.- Tuercas completas
                        ["subtarea" => "¿Las llantas cuentan con sus tuercas completas?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 5.- Llantas de repuesto
                        ["subtarea" => "¿La unidad cuenta con llantas de repuesto?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 6.- Herramientas y señales reflejantes
                        ["subtarea" => "¿La unidad cuenta con herramientas y señales reflejantes?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 7.- Lonas en buen estado
                        ["subtarea" => "¿La unidad cuenta con lonas en buen estado?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 8.- Cantidad de lonas adecuada
                        ["subtarea" => "¿La cantidad de lonas es la adecuada?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 9.- Herramientas para ajustar
                        ["subtarea" => "¿La unidad cuenta con herramientas para ajustar?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 10.- Tipo de herramienta de ajustar
                        ["subtarea" => "Ingrese el tipo de herramientas para ajustar con que cuenta la unidad",  "texto_ayuda" => "Ejemplo: Cadenas, Lazos, Slingas, Fajas ... Etc. ", "inputType" => "text"],
                        // 11.- Funcionamiento de luces indicadoras
                        ["subtarea" => "¿Las luces indicadoras funcionan adecuadamente?",  "texto_ayuda" => "", "inputType" => "check"],
                        // 12.- Observaciones generales de la plataforma o caja
                        ["subtarea" => "Escriba las observaciones generales de la plataforma o caja", "texto_ayuda" => "",  "inputType" => "textarea"],        
                    ]
                ]

            ],
            [
                "tarea" => [
                    "coordinacion_id" => $coordinacion_id,
                    "titulo_corto" => "Validación Previa",
                    "titulo_largo" => "Previa validación del trasbordo",
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
                        //1.- Toma de foto inicial
                        ["subtarea" => "Foto inicial", "texto_ayuda" => "Capture la foto inicial",  "inputType" => "photos"],
                        //2.- Numero de gatas
                        ["subtarea" => "Numero de gatas", "texto_ayuda" => "Inserte el numero de gatas",  "inputType" => "number"],
                        //3.- Fotos del proceso de carga 
                        ["subtarea" => "Fotos del proceso de descarga", "texto_ayuda" => "Inserte las fotos del proceso de descarga",  "inputType" => "photos", "limit" => 15],
                        //4.- Observaciones de la mercancia
                        ["subtarea" => "Observaciones de la mercancia", "texto_ayuda" => "Escriba las observaciones de la mercancia",  "inputType" => "textarea"],
                        //5.- Evidencia de irregularidades
                        ["subtarea" => "Evidencia de irregularidades", "texto_ayuda" => "Encaso de que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
                    ],
                    "CENTROAMERICANO" => [
                        //1.- Toma de foto inicial
                        ["subtarea" => "Foto inicial", "texto_ayuda" => "Capture la foto inicial",  "inputType" => "photos"],
                        //2.- Fotos del proceso de carga 
                        ["subtarea" => "Fotos del proceso de carga", "texto_ayuda" => "Inserte las fotos del proceso de descarga",  "inputType" => "photos", "limit" => 15],
                        //3.- Observaciones de la mercancia
                        ["subtarea" => "Observaciones de la mercancia", "texto_ayuda" => "Escriba las observaciones de la mercancia",  "inputType" => "textarea"],
                        //4.- Evidencia de irregularidades
                        ["subtarea" => "Evidencia de irregularidades", "texto_ayuda" => "Encaso de que haya irregularidades capture las fotos necesarias",  "inputType" => "photos", "limit"=>99, "required" => 0 ],
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
                    ["subtarea" => "Entrega de documentación", "texto_ayuda" => "La documentación sera entregada en la recepción de docuemntos (Trafico)",  "inputType" => "aviso", "options" => "info"],
                ]
            ],
        ];
    }
}
