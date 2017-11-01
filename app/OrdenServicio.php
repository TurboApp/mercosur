<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;
use Jenssegers\Date\Date;
use Carbon\Carbon;

class OrdenServicio extends Model
{
    use SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'orden_servicios.destino' => 10,
        ],
    ];
    
    protected $dates=['fecha_recepcion'];
    // public function fechaRecepcionDate()
    // {
    //     return Carbon::createFromFormat('m/d/Y', $this->fecha_resepcion);
    // }

    public function getTodayAttribute($date)
    {
        return new Date($date);
    }
    
    public static function getNumServicio()
    {
        if(OrdenServicio::orderBy('id','desc')->first()){
            return OrdenServicio::orderBy('id','desc')->first()->id + 1;
        }else{
            return 1;
        }
    }

    public static function createOrdenServicio($data)
    {
        $datos_generales = array();
        $datos_generales = $data;
        $numero_servicio = OrdenServicio::getNumServicio();
        $date = str_replace('/', '-', $datos_generales['fecha_recepcion']);
        $datos_generales['numero_servicio'] = $numero_servicio;
        $datos_generales['fecha_recepcion'] = date('Y-m-d', strtotime($date));
        $datos_generales['status'] = 'Para asignar';
        return OrdenServicio::create($datos_generales);
    }

    public function addTransportes($data)
    {
        OrdenServicioTransporte::create(['id_orden_servicio' => $this->id] + $data);
    }

    public function addDocumentos($type, $data)
    {   
        foreach($data as $documento){
            $date = Date::now();
            $descarga=[
                'descarga_id' => $this->id,
                'fecha_descarga' => $date,
                'status' => '1'
            ];
            $trasbordo=[
                'descarga_id' => $this->id,
                'carga_id' => $this->id,
                'fecha_descarga' => $date,
                'fecha_carga' => $date,
                'status' => '1'
            ];
            
            if($type==='Descarga'){
                Documento::create( $descarga + $documento );
            }elseif($type==='Trasbordo'){
                Documento::create( $trasbordo + $documento );
            }
        }
    }
    public function updateDocumentos($documentos)
    {   
        foreach($documentos as $key => $val){
            Documento::where('id','=',$val)->update(
                [
                    'carga_id'  => $this->id,
                    'status'    => 0
                ]
            );
        }
    }
    

    public function storearchivos($type, $archivos){
       
        foreach ($archivos as $archivo) 
        {
            $size = (int) $archivo->getClientSize();
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            if($type==='Descarga'){
                $file['descarga_id'] = $this->id;
            }else{
                $file['descarga_id'] = $this->id;
                $file['carga_id'] = $this->id;
            }
            $file['url'] = $archivo->storeAs('documentos/'.$this->numero_servicio, $archivo->getClientOriginalName());
            $file['size'] = round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
            $file['extension'] = $archivo->getClientOriginalExtension();
            $file['nombre'] = $archivo->getClientOriginalName();
            $file['minetype'] = $archivo->getClientMimeType();
            Archivo::create($file);
        }
       
    }

    public function updateArchivos($archivos)
    {   
        foreach($archivos as $key => $val){
            Archivo::where('id', $val)->update(
                [
                    'carga_id'  => $this->id,
                ]
            );
        }
    }
    
    //Relaciones
    public function cliente(){
        return $this->hasOne('App\Cliente','id','cliente_id');  
    }
    public function agente(){
        return $this->hasOne('App\Agente','id','agente_id');  
    }
    
    public function documentosDescarga()
    {
        return $this->hasMany('App\Documento','descarga_id','id');
    }
    public function documentosCarga()
    {
        return $this->hasMany('App\Documento','carga_id','id');
    }
    
    public function transportes()
    {
        return $this->hasMany('App\OrdenServicioTransporte','id_orden_servicio','id');
    }
    public function archivosDescarga()
    {
        return $this->hasMany('App\Archivo','descarga_id','id');
    }
    public function archivosCarga()
    {
        return $this->hasMany('App\Archivo','carga_id','id');
    }

    
}

