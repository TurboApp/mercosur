<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Agente;
use App\Coordinacion;
use App\User;
use App\Equipo;
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
        
        if( auth()->user()->perfil_id < 4  )
        {   
            $equipos = Equipo::paginate(16);
            
            foreach($equipos as $equipo){
                $descargas = Servicio::where('tipo', 'Descarga')->whereHas('autor', function($q) use($equipo){
                    $q->where('equipo_id',$equipo->id);
                })->count();
                $equipo->descargas = $descargas;

                $cargas = Servicio::where('tipo', 'Carga')->whereHas('autor', function($q) use($equipo){
                    $q->where('equipo_id',$equipo->id);
                })->count();
                $equipo->cargas = $cargas;

                $trasbordos = Servicio::where('tipo', 'Trasbordo')->whereHas('autor', function($q) use($equipo){
                    $q->where('equipo_id',$equipo->id);
                })->count();
                $equipo->trasbordos = $trasbordos;
            }

            return view('pages.servicios.teams', compact('data','equipos'));
        }
        return view('pages.servicios.index', compact('data'));
    }

    public function indexEquipo(Request $request)
    {
        
        $data = Date::instance(Carbon::now());
        $equipo = Equipo::find($request->equipo);
        return view('pages.servicios.indexTiempo', compact('data','equipo'));
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
                'url' => '/coordinacion'
            ]);
            event(new notificaciones($notifi));
            event(new ManiobraInicio($notifi));
        }

        $supervisores = User::where([ ['perfil_id',6],['equipo_id', auth()->user()->equipo_id]])->get();
        foreach($supervisores as $supervisor)
        {
            $notifi = Notification::create([
                'emisor_id' => $emisor, 
                'receptor_id' => $supervisor->id,
                'titulo' => 'Un nuevo servicio se creo recientemente',
                'mensaje' => 'Servicio '.  $servicio->tipo . '. Num. ' . $servicio->numero_servicio,
                'url_icon' => '/img/pushIcon/round.png',
                'url' => '/maniobras'
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

    public function edit(Request $request, $servicio)
    {
        $servicio = Servicio::find($servicio);
        
        if ($servicio) {
            return view('pages.servicios.edit', compact('servicio'));
        }
        else
        {
            $request->session()->flash('danger', 'No se encontro ningun dato');
            return redirect('/servicios');
        }
    }

    
    
    public function editProductividad(Request $request, $servicio)
    {
        $servicio = Servicio::find($servicio);
        if ($servicio) {
            $coordinacion = $servicio->coordinacion;
            //dd($coordinacion->created_at);
            return view('pages.servicios.editProductividad', compact('servicio', 'coordinacion'));
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
