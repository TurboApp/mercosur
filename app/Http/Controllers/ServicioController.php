<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Agente;
use App\Coordinacion;
use App\User;
use App\Notification;
use App\Http\Requests\RequestServicio;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use File;
use Response;

use App\Events\notificaciones;
use App\Events\ManiobraInicio;

use Illuminate\Http\Request;

class ServicioController extends Controller
{
    function __construct(){
        $this->middleware(['auth','perfils:trafico,admin,supervisor,coordinador,go,directivo']);
    }

    public function index()
    {   
        $data = Date::instance(Carbon::now());
        if( auth()->user()->perfil->perfil == 'go' || auth()->user()->perfil->perfil == 'directivo' )
        {
            return view('pages.productividad.servicios.index', compact('data'));
        }
        return view('pages.servicios.index', compact('data'));
    }

    public function almacen()
    {
        $data = Date::instance(Carbon::now());
        return view('pages.servicios.almacen', compact('data'));
    }

    public function create(Request $request)
    {
        if($request->servicio !== "Descarga" && $request->servicio !== "Carga" && $request->servicio !== "Trasbordo")
        {
            $request->session()->flash('danger', 'No se encontro ningun dato');
            return redirect('/servicios/nuevo');
        }

        $servicio='';
        
        if($request->id)
        {
            $servicio = Servicio::find($request->id);
            if(!$servicio || $request->servicio !== "Carga")
            {
                $request->session()->flash('danger', 'No se encontro ningun dato');
                return redirect('/servicios/nuevo');
            }
        }

        $data = [
            "numero_servicio" => Servicio::getNumServicio(),
            "agentes" => Agente::get(),
            "hoy" => Date::instance(Carbon::now()),
            "tipo" => $request->servicio
        ];
        
        return view('pages.servicios.create', compact('data','servicio'));
    }

    public function new(){
        return view('pages.servicios.new');
    }

    public function store(RequestServicio $request){
        
        //Store Datos generales 
        $servicio=Servicio::storeDatosGenerales( 
            ['tipo' => $request->tipo] + 
            [ 'user_id' => auth()->user()->id] + 
            $request->datos_generales 
        );
        
        //Store Transportes  
        $servicio->storeTransportes( $request->transporte );
        
        //Store Documentos
        $servicio->storeDocumentos( $request->documento );

        //Store Archivos
        if($request->hasFile('files')){
            $servicio->storeArchivos($request->file('files'));
        }
       
        //Asignar turno
        $coordinacion_id = $servicio->asignarTurno( $request->datos_generales['fecha_recepcion']);
        $servicio->fill([ "coordinacion_id" => $coordinacion_id ])->save();

        // Tareas de Maniobra
        $servicio->prepararTareas($coordinacion_id);

        $coordinadores = User::where([ ['perfil_id',5],['equipo_id', auth()->user()->equipo_id]])->get();
        $emisor = auth()->user()->id;
        foreach($coordinadores as $coordinador)
        {
            $notifi = Notification::create([
                'emisor_id' => $emisor, 
                'receptor_id' => $coordinador->id,
                'titulo' => 'Un nuevo servicio se creo recientemente',
                'mensaje' => 'Servicio '.  $servicio->tipo . '. Num. ' . $servicio->numero_servicio,
                'url_icon' => '/img/pushIcon/round.png',
                'url' => '/coordinacion/'
            ]);
            event(new notificaciones($notifi));
            event(new ManiobraInicio($notifi));
        }

        $request->session()->flash('success', 'El servicio se creo satisfactoriamente');


        return redirect("/servicios/".$servicio->id); 
    }

    public function show(Request $request, $servicio)
    {
        $servicio=Servicio::find($servicio);
        
        if ($servicio) {
            return view('pages.servicios.show', compact('servicio'));
        }
        else
        {
            $request->session()->flash('danger', 'No se encontro ningun dato');
            return redirect('/servicios');
        }
    }

    public function getArchivo(Request $request)
    {
        $path = storage_path('app/documentos/'.$request->id .'/'. $request->archivo );
        if(!File::exists($path)) 
            $path = storage_path('app/public/avatars/') . 'default.png';
        
        $file = File::get($path);
        
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
        //return view('pages.viewer.index', compact('response'));
    }

}
