<?php

namespace App\Http\Controllers;

use DateTime;

use File;

use Response;

use App\Coordinacion;
use App\ManiobraTarea  as Tareas;
use App\ManiobraSubtarea as Subtarea;
use App\ManiobraSubtareaAttachment as Attach;
use App\FuerzaTarea;
use App\ProduccionOperarios;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getTarea(Request $request)
    {
        $tarea = Tareas::find($request->id);
        return $tarea->toJson();
    }
    
    public function getPhotos(Request $request)
    {
        $photo = Attach::where('subtarea_id', $request->photo)->get();
        return $photo->toJson();
    }

    public function getFilePhoto(Request $request)
    {
        $a=$request->a;
        $m=$request->m;
        $d=$request->d;
        $photo=$request->photo;
        $path = storage_path('app/maniobras_attachment/'.$a .'/'. $m .'/'. $d .'/' .'/'. $photo );
        
        if(!File::exists($path)) 
            $path = storage_path('app/maniobras_attachment/') . 'imagen-no-encontrada.jpg';
        
        $file = File::get($path);
        
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
        //return view('pages.viewer.index', compact('response'));
    }

    public function getSignature(Request $request)
    {
        $firma = Subtarea::where([
            ['id', $request->tarea_id],
            ['subtarea', $request->subtarea]
            ])->first();
        return $firma->toJson();
    }
    public function getFileSignature(Request $request)
    {
        $image=$request->signature;
        
        $path = storage_path('app/signatures/'.$image );
        
        $file = File::get($path);
        
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
        //return view('pages.viewer.index', compact('response'));
    }

    public function getOperarios( Request $request )
    {
        if($request->s)
        {
            $operarios = FuerzaTarea::where([
                ['nombre', 'LIKE','%'.$request->s.'%'],
                ['status','0']
                ])->get();
        }
        else 
        {
            $operarios = FuerzaTarea::where('status','0')->get();
        }
        
        return $operarios->toJson();
    }
    public function getOperariosActivos( Request $request )
    {
        //dd($request->coordinacionid);
            
        $operarios = FuerzaTarea::where( 'coordinacion_id',$request->coordinacionid )->get();
                
        return $operarios->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    public function updateProduccionFuerzaTarea(Request $request)
    {
        /*
        Verifica si existe el operario en la base de datos con el id de coordinacion
        */ 
        $produccion = ProduccionOperarios::where([
            ['coordinacion_id', $request->coordinacion],
            ['fuerza_tarea_id', $request->operario]
        ])->get();

        if( $request->tipo == "insertar" )
        {
            if($produccion->isEmpty()) //No exiete en la base de datos
            {
                //  la accion es insertar y no existe registro de este operario en esta maniobra
                // entonses se inserta pero no se ingresa fech y hora de inicio de la maniobra
                $produccion = ProduccionOperarios::create([
                    'coordinacion_id' => $request->coordinacion ,
                    'fuerza_tarea_id' => $request->operario 
                ]);
            }
            else //si existe en la base de datos
            {
                // Si existe en la base de datos se compara si ya tiene una fecha-hora de finalizacion
                // si no es null o sea si ya finalizo pero volvera a activarse otra vez se inserta nuevo registro
                // 
                $x = $produccion->where('final', null);
                if(! $x->count() )
                {
                    $produccion = ProduccionOperarios::create([
                        'coordinacion_id' => $request->coordinacion ,
                        'fuerza_tarea_id' => $request->operario 
                    ]);
                }

            
            }
        }
        elseif( $request->tipo == "eliminar" )
        {
            // La accion es eliminar se verifica si existe en la base de datos/colleccion
            // si si existe se prosede a lo siguiente
            if(!$produccion->isEmpty()) //Si exiete en la base de datos
            {  
                //se recorre el collection 
                $produccion = $produccion->each(function ($item, $key){
                    // Si esta vacio inicio quiere decir que no ha empesado con la maniobra
                    // por lo tanto de elimina
                    //dd($produccion);
                    if( ! $item->inicio )
                    {
                        $item->delete();
                    }
                    // Si no esta vacion inicio se verifica si esta vacio la fecha-hora final
                    // si aun no hay fehca-hora final se le asigna una 
                    elseif( ! $item->final )
                    {
                        $item->final = date("Y-m-d H:i:s");
                        $item->save();
                    }
                });
           
            }
            
        } 
        // cuando se inicia la maniobra
        elseif( $request->tipo == "iniciar" )
        {
            // Hace el recorrido de cada elemento
            $produccion->each(function ($item, $key){
                // si el inicio es null añade la fecha y hora 
                if( ! $item->inicio )
                {
                    $item->inicio = date("Y-m-d H:i:s");
                    $item->save();
                }
            });
        }

        return ;
    }


    public function storeSubtarea(Request $request)
    {
        $subtarea='';
        if( $request->inputType  == 'photo' )
        {
            $foto = $request->file('file');
            $a = date("Y");
            $m = date("m");;
            $d = date("j");
            if($request->hasFile('file'))
            {
                $size = (int) $foto->getClientSize();
                $base = log($size) / log(1024);
                $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
                
                $file['url'] = $request->file('file')->store('maniobras_attachment/'.$a.'/'.$m.'/'.$d);
                $file['size'] = round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
                $file['extension'] = $foto->getClientOriginalExtension();
                $file['minetype'] = $foto->getClientMimeType();
                
                $subtarea = Attach::create( [ 'subtarea_id' => $request->id] + $file );
            }
            
        }
        elseif($request->inputType == 'firma')
        {
            $encoded_image = explode(",", $request->file )[1];
            $signature = base64_decode($encoded_image);
            $nameImage = str_replace(" ", "-",$request->name);
            $now = new DateTime();
            if(!File::exists('../storage/app/signatures/')) {
                File::makeDirectory('../storage/app/signatures/');
            }
            $path='signatures/'.$now->getTimestamp().'-'.$nameImage.'.png';
            $file = file_put_contents('../storage/app/'.$path, $signature);
            if($file){
                $subtarea = Subtarea::find($request->id);
                $subtarea->value = $path; 
                $subtarea->save();
            }
        }
        else{
            $subtarea = Subtarea::find($request->id);
            $subtarea->value = $request->value; 
            $subtarea->save();
        }

        return $subtarea->toJson();
    }

    public function destroySubtarea(Request $request){
        if( $request->inputType === 'photo' )
        {
            $del = Attach::find($request->id);
           
            if (count($del)) {
                storage::delete($del->url);
                $del->delete();
            }
        }
        elseif($request->inputType === 'signature')
        {
            $signature = Subtarea::find($request->id);
            if (count($signature)) {
                storage::delete($signature->value);
                $signature->value = ''; 
                $signature->save();
            }
        }    
    
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ManiobraSubtarea  $maniobraSubtarea
     * @return \Illuminate\Http\Response
     */
    public function show(ManiobraSubtarea $maniobraSubtarea)
    {
        //
    }

    public function updateFuerzaTarea(Request $request)
    {
        $operario = FuerzaTarea::find($request->id);
        $operario->status = $request->status;
        $operario->coordinacion_id=$request->coordinacion;
        $operario->save();
        
        return $operario->toJson();
    }

    public function tareaTimer(Request $request)
    {
        $tarea = Tareas::find($request->tareaId);
        $now = Carbon::now();
        if($request->option === 'inicio'){
            if(!$tarea->inicio){
                $tarea->inicio = $now; 
                $tarea->status ='en proceso';
                $tarea->save();
            }
        }elseif($request->option === 'fin'){
            if(!$tarea->final){
                $tarea->final = $now; 
                $tarea->status ='finalizado';
                $tarea->save();
            }
        }
        return $tarea->toJson();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManiobraSubtarea  $maniobraSubtarea
     * @return \Illuminate\Http\Response
     */
    public function edit(ManiobraSubtarea $maniobraSubtarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManiobraSubtarea  $maniobraSubtarea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManiobraSubtarea $maniobraSubtarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManiobraSubtarea  $maniobraSubtarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManiobraSubtarea $maniobraSubtarea)
    {
        //
    }
}