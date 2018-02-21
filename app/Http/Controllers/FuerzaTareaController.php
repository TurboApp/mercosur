<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\FuerzaTarea;
Use App\User;
use App\ProduccionOperarios;
use App\Coordinacion;
use Carbon\Carbon;
use DataTables;
use Jenssegers\Date\Date;

class FuerzaTareaController extends Controller
{
    function __construct(){
      $this->middleware(['auth','perfils:admin,go,directivo']);
    }

    public function index(){
      $fuerzas=FuerzaTarea::latest()->paginate(16);
      return view('pages.fuerzas.index',compact('fuerzas'));
    }

    public function create()
    {
      return view('pages.fuerzas.create');
    }

    public function store(Request $request){
      $this->validate($request,[
        'nombre' => 'required',
        'categoria' => 'required',

      ]);
      $fuerzas=(new FuerzaTarea)->fill($request->all());
      $fuerzas->save();
      $request->session()->flash('success', 'Un nuevo operario '.$fuerzas->nombre.' se agrego satisfactoriamente');
      return redirect('/fuerzas/');
    }

    public function show(Request $request, $fuerza){
      $fuerza=FuerzaTarea::find($fuerza);
      if ($fuerza===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/fuerzas/');
      } else {
        return view('pages.fuerzas.show',compact('fuerza'));
      }

    }

    public function edit(Request $request, $fuerza){
      $fuerza=FuerzaTarea::find($fuerza);
      if ($fuerza===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/fuerzas/');
      }
      else {
        return view('pages.fuerzas.edit',compact('fuerza'));
      }
    }

    public function update(Request $request, FuerzaTarea $fuerza){
        $this->validate($request,[
          'nombre' => 'required',
          'categoria' => 'required',
        ]);
        $fuerza=FuerzaTarea::find($fuerza->id);
        $fuerza->update($request->only('nombre','apellido','direccion','telefono','celular','categoria'));
        $request->session()->flash('success', 'El operario '.$fuerza->nombre.' se ha actualizado satisfactoriamente');
        return redirect('/fuerzas/'.$fuerza->id);
    }

    public function destroy(Request $request, FuerzaTarea $fuerza){
      $eliminar=FuerzaTarea::find($fuerza->id);
      if(count($eliminar)){
        $eliminar->delete();
      }
      $request->session()->flash('success', 'El registro fue elimado');
    }

    public function search(Request $request)
   {
       $fuerzas = FuerzaTarea::where('nombre', 'LIKE','%'.$request->s.'%')->paginate(16);
       $fuerzas->appends( [ 's' => $request->s ] );

       return view('pages.fuerzas.search', compact('fuerzas','request'));
   }

  ////// PRODUCCION OPERARIOS
    public function operariosProduccion(){
      $fuerzas=FuerzaTarea::latest()->paginate(16);
      return view('pages.productividad.operarios.index',compact('fuerzas'));
    }

    public function searchOperariosProduccion(Request $request)
    {
       $fuerzas = FuerzaTarea::where('nombre', 'LIKE','%'.$request->s.'%')->paginate(16);
       $fuerzas->appends( [ 's' => $request->s ] );

       return view('pages.productividad.operarios.search', compact('fuerzas','request'));
    }

    public function showOperario(Request $request, $operario){
      
      $operario = FuerzaTarea::find($operario);
      $operario['fecha'] = Date::instance(Carbon::now());
      if ($operario===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/operarios-produccion/');
      }
      $produccion = produccionOperarios::where([
          ['fuerza_tarea_id',$operario->id],
          ['final','!=','Null']
          ])->get();
      
      $productividad = collect();
      $productividad->tiempoTotal = 0;
      $productividad->tiempoCargas=0;
      $productividad->tiempoDescargas = 0;
      $productividad->tiempoTrasbordos = 0;
      $productividad->descargas = 0;
      $productividad->cargas = 0;
      $productividad->trasbordos = 0;
      $productividad->total = 0;
      
  
      $week = array(
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
     );
     
     if($produccion->isEmpty()){
         $productividad->semana = $week;
         return view('pages.productividad.operarios.show', compact('operario', 'productividad'));
     }
      
      $tiempoTotal=0;
      $cargas=0; $tiempoCargas=0;
      $descargas=0; $tiempoDescargas=0;
      $trasbordos=0; $tiempoTrasbordos=0;
      foreach( $produccion as $actividad ){
          $inicio = new Carbon($actividad->inicio, 'America/Mexico_City');
          $final = new Carbon($actividad->final, 'America/Mexico_City');
          $tiempoTotal += $inicio->diffInSeconds($final, false);
          if($actividad->coordinacion->servicio->tipo == 'Carga')
          {
            $cargas += 1;
            $tiempoCargas += $inicio->diffInSeconds($final, false);
          }
          elseif($actividad->coordinacion->servicio->tipo == 'Descarga')
          {
            $descargas +=1;
            $tiempoDescargas += $inicio->diffInSeconds($final, false);
          }
          elseif($actividad->coordinacion->servicio->tipo == 'Trasbordo')
          {
            $trasbordos +=1;
            $tiempoTrasbordos += $inicio->diffInSeconds($final, false);
          }
      }

      $productividad->tiempoTotal = gmdate("H:i:s",$tiempoTotal);
      $productividad->tiempoCargas = gmdate("H:i:s",$tiempoCargas);
      $productividad->tiempoDescargas = gmdate("H:i:s",$tiempoDescargas);
      $productividad->tiempoTrasbordos = gmdate("H:i:s",$tiempoTrasbordos);
      $productividad->cargas = $cargas;
      $productividad->descargas = $descargas;
      $productividad->trasbordos = $trasbordos;
      $productividad->total = $trasbordos + $cargas + $descargas;;
    
      $diaSemana = Carbon::parse($produccion->last()->final);

       
        if($diaSemana->dayOfWeek == 1){
            $inicio = $produccion->last()->final;
            $semana = produccionOperarios::whereDate("final", $inicio)
                    ->where('fuerza_tarea_id',$operario->id)->get();
        }else{
            $inicio = $diaSemana->subDays($diaSemana->dayOfWeek - 1);
            $fin = $produccion->last()->final;
            $semana = produccionOperarios::whereBetween("final", [$inicio,$fin])
                      ->where('fuerza_tarea_id',$operario->id)->get();
        }
        
          
        foreach( $semana as $dia ){
          $day = Carbon::parse($dia->final);
          for($i = $day->dayOfWeek; $i > 0; $i-- ){
            if($day->dayOfWeek == $i)
            {
              if($dia->coordinacion->servicio->tipo == 'Carga')
              {
                $week[$i-1]['cargas'] = $week[$i-1]['cargas'] + 1;
              }
              elseif($dia->coordinacion->servicio->tipo == 'Descarga')
              {
                $week[$i-1]['descargas'] = $week[$i-1]['descargas'] + 1;
              }
              elseif($dia->coordinacion->servicio->tipo == 'Trasbordo')
              {
                $week[$i-1]['trasbordos'] = $week[$i-1]['trasbordos'] + 1;
              }
            }
          }
        }
        $productividad->semana = $week;

      
      return view('pages.productividad.operarios.show', compact('operario', 'productividad'));
    }

    public function getDataOperario(Request $request, $operario)
    {
      $operario = FuerzaTarea::find($operario);
      $fecha=Carbon::today()->format('Y-m-d');
      $fechas=explode("*",$request->date);

      if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
 
            $produccion = produccionOperarios::whereBetween("created_at", [$fechaInicio,$fechaFinal])
                          ->where('fuerza_tarea_id',$operario->id)
                          ->with(['coordinacion.servicio.cliente'])
                          ->get();
        }
        else if( $request->date )
        {
          $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
          $produccion = produccionOperarios::whereDate("created_at", $fecha)
              ->where('fuerza_tarea_id',$operario->id)
              ->with(['coordinacion.servicio.cliente'])
              ->get();
         
        }
        else
        {
          $produccion = produccionOperarios::whereDate("created_at", $fecha)
              ->where('fuerza_tarea_id',$operario->id)
              ->with(['coordinacion.servicio.cliente'])
              ->get();

              
        }

      
      foreach($produccion as $servicio)
      {
        $inicio = new Carbon($servicio->inicio, 'America/Mexico_City');
        $date_humans=Date::instance($servicio->created_at)->format('F j, Y');
        $servicio['date_humans'] = $date_humans;
        if($servicio->inicio && $servicio->final){
          $final  = new Carbon($servicio->final, 'America/Mexico_City');
          $duracion = $inicio->diffInSeconds($final, false); 
          $servicio['duracion'] = gmdate("H:i:s",$duracion) . ' Hrs.';
          $servicio['horaInicio'] = $inicio->format('H:i:s') . ' Hrs.';
          $servicio['horaFinal'] = $final->format('H:i:s') . ' Hrs.';
        }elseif(!$servicio->final){
          $servicio['duracion'] = '...';
          $servicio['horaInicio'] = $inicio->format('H:i:s') . ' Hrs.';
          $servicio['horaFinal'] = '...';
        }
      }

      //dd($produccion);
      
      return DataTables::of($produccion)->toJson();
    }

    //PRODUCCION SUPERVISORES
    public function supervisoresProduccion(){
      $supervisores=User::whereHas('perfil', function($q){
        $q->where('perfil','supervisor');
      })->paginate(16);
      return view('pages.productividad.supervisores.index',compact('supervisores'));
    }

    public function searchSupervisoresProduccion(Request $request)
    {
       $supervisores = User::whereHas('perfil', function($q) use ($request){
         $q->where([
           ['perfil','supervisor'],
           ['nombre', 'LIKE','%'.$request->s.'%']
           ]);
       })->paginate(16);
       
       $supervisores->appends( [ 's' => $request->s ] );

       return view('pages.productividad.supervisores.search', compact('supervisores','request'));
    }

    public function showSupervisor(Request $request, $supervisor){
      
      $supervisor = User::whereHas('perfil', function($q){
          $q->where('perfil','supervisor');
      })->where('id', $supervisor)->first();
      
      
      $supervisor['fecha'] = Date::instance(Carbon::now());
      if ($supervisor===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/supervisores/');
      }
      $produccion = Coordinacion::where('supervisor_id', $supervisor->id)->get();
      
      $productividad = collect();
      $productividad->tiempoTotal = 0;
      $productividad->tiempoCargas=0;
      $productividad->tiempoDescargas = 0;
      $productividad->tiempoTrasbordos = 0;
      $productividad->descargas = 0;
      $productividad->cargas = 0;
      $productividad->trasbordos = 0;
      $productividad->total = 0;
      
  
      $week = array(
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
     );
     
     if($produccion->isEmpty()){
         $productividad->semana = $week;
         return view('pages.productividad.supervisores.show', compact('supervisor', 'productividad'));
     }
      
      $tiempoTotal=0;
      $cargas=0; $tiempoCargas=0;
      $descargas=0; $tiempoDescargas=0;
      $trasbordos=0; $tiempoTrasbordos=0;
      foreach( $produccion as $actividad ){
          $inicio = new Carbon($actividad->inicio_maniobra, 'America/Mexico_City');
          $final = new Carbon($actividad->termino_maniobra, 'America/Mexico_City');
          $tiempoTotal += $inicio->diffInSeconds($final, false);
          if($actividad->servicio->tipo == 'Carga')
          {
            $cargas += 1;
            $tiempoCargas += $inicio->diffInSeconds($final, false);
          }
          elseif($actividad->servicio->tipo == 'Descarga')
          {
            $descargas +=1;
            $tiempoDescargas += $inicio->diffInSeconds($final, false);
          }
          elseif($actividad->servicio->tipo == 'Trasbordo')
          {
            $trasbordos +=1;
            $tiempoTrasbordos += $inicio->diffInSeconds($final, false);
          }
      }

      $productividad->tiempoTotal = gmdate( "H:i:s" , $tiempoTotal);
      $productividad->tiempoCargas = gmdate( "H:i:s" , $tiempoCargas);
      $productividad->tiempoDescargas = gmdate( "H:i:s" , $tiempoDescargas);
      $productividad->tiempoTrasbordos = gmdate( "H:i:s" , $tiempoTrasbordos);
      $productividad->cargas = $cargas;
      $productividad->descargas = $descargas;
      $productividad->trasbordos = $trasbordos;
      $productividad->total = $trasbordos + $cargas + $descargas;;
            
      $diaSemana = Carbon::parse($produccion->last()->termino_maniobra);

      $lunes = Carbon::now()->startOfWeek();
      $domingo = Carbon::now()->endOfWeek();
      if( $diaSemana->between( $lunes , $domingo ) )
      {
        if($diaSemana->dayOfWeek == 1){
          $inicio = $produccion->last()->termino_maniobra;
          $semana = Coordinacion::whereDate("termino_maniobra", $inicio)->where('supervisor_id', $supervisor->id)->get();
        }else{
          $inicio = $diaSemana->subDays( $diaSemana->dayOfWeek - 1);
          $fin = $produccion->last()->termino_maniobra;
          $semana = Coordinacion::whereBetween("termino_maniobra", [$inicio, $fin])->where('supervisor_id', $supervisor->id)->get();
        }
        foreach( $semana as $dia ){
          $day = Carbon::parse($dia->final);
          for($i = $day->dayOfWeek; $i > 0; $i-- ){
            if($day->dayOfWeek == $i)
            {
              if($dia->coordinacion->servicio->tipo == 'Carga')
              {
                $week[$i-1]['cargas'] = $week[$i-1]['cargas'] + 1;
              }
              elseif($dia->coordinacion->servicio->tipo == 'Descarga')
              {
                $week[$i-1]['descargas'] = $week[$i-1]['descargas'] + 1;
              }
              elseif($dia->coordinacion->servicio->tipo == 'Trasbordo')
              {
                $week[$i-1]['trasbordos'] = $week[$i-1]['trasbordos'] + 1;
              }
            }
          }
        }

      }  
      
      $productividad->semana = $week;
      
      return view('pages.productividad.supervisores.show', compact('supervisor', 'productividad'));
    }


    public function getDataSupervisor(Request $request, $supervisor)
    {
      $supervisor = User::find($supervisor);
      $fecha=Carbon::today()->format('Y-m-d');
      $fechas=explode("*",$request->date);

      if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
 
            $produccion = Coordinacion::whereBetween("fecha_servicio", [$fechaInicio, $fechaFinal])
                          ->where('supervisor_id',$supervisor->id)
                          ->with(['servicio.cliente'])
                          ->get();
        }
        else if( $request->date )
        {
          $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
          $produccion = Coordinacion::whereDate("fecha_servicio", $fecha)
              ->where('supervisor_id',$supervisor->id)
              ->with(['servicio.cliente'])
              ->get();
         
        }
        else
        {
          $produccion = Coordinacion::whereDate("fecha_servicio", $fecha)
              ->where('supervisor_id',$supervisor->id)
              ->with(['servicio.cliente'])
              ->get();

              
        }

      
      foreach($produccion as $servicio)
      {
        $inicio = new Carbon($servicio->inicio, 'America/Mexico_City');
        $date_humans=Date::instance($servicio->created_at)->format('F j, Y');
        $servicio['date_humans'] = $date_humans;
        if($servicio->inicio && $servicio->final){
          $final  = new Carbon($servicio->final, 'America/Mexico_City');
          $duracion = $inicio->diffInSeconds($final, false); 
          $servicio['duracion'] = gmdate("H:i:s",$duracion) . ' Hrs.';
          $servicio['horaInicio'] = $inicio->format('H:i:s') . ' Hrs.';
          $servicio['horaFinal'] = $final->format('H:i:s') . ' Hrs.';
        }elseif(!$servicio->final){
          $servicio['duracion'] = '...';
          $servicio['horaInicio'] = $inicio->format('H:i:s') . ' Hrs.';
          $servicio['horaFinal'] = '...';
        }
      }

      //dd($produccion);
      
      return DataTables::of($produccion)->toJson();
    }

    //PRODUCCION COORDINADORES
    public function coordinadoresProduccion(){
      $coordinadores=User::whereHas('perfil', function($q){
        $q->where('perfil','coordinador');
      })->paginate(16);
      return view('pages.productividad.coordinadores.index',compact('coordinadores'));
    }

    
    public function searchCoordinadoresProduccion(Request $request)
    {
       $coordinadores = User::whereHas('perfil', function($q) use ($request){
         $q->where([
           ['perfil','coordinador'],
           ['nombre', 'LIKE','%'.$request->s.'%']
           ]);
       })->paginate(16);
       
       $coordinadores->appends( [ 's' => $request->s ] );

       return view('pages.productividad.coordinadores.search', compact('coordinadores','request'));
    }

    public function showCoordinador(Request $request, $coordinador){
      
      $coordinador = User::whereHas('perfil', function($q){
          $q->where('perfil','coordinador');
      })->where( 'id' , $coordinador )->first();
      
      
      $coordinador['fecha'] = Date::instance(Carbon::now());
      if ($coordinador===null) {
        $request->session()->flash('danger', 'No se encontro ningun dato');
        return redirect('/coordinadores/');
      }
      $produccion = Coordinacion::where('coordinador_id', $coordinador->id)->get();
      
      $productividad = collect();
      $productividad->tiempoTotal = 0;
      $productividad->tiempoCargas=0;
      $productividad->tiempoDescargas = 0;
      $productividad->tiempoTrasbordos = 0;
      $productividad->descargas = 0;
      $productividad->cargas = 0;
      $productividad->trasbordos = 0;
      $productividad->total = 0;
      
      $week = array(
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
        [ 'descargas' => 0, 'cargas' => 0, 'trasbordos' =>0 ],
      );
     
      if($produccion->isEmpty()){
         $productividad->semana = $week;
         return view('pages.productividad.coordinadores.show', compact('coordinador', 'productividad'));
      }
      
      $tiempoTotal=0;
      $cargas=0; $tiempoCargas=0;
      $descargas=0; $tiempoDescargas=0;
      $trasbordos=0; $tiempoTrasbordos=0;
      foreach( $produccion as $actividad ){
          $inicio = new Carbon($actividad->inicio_maniobra, 'America/Mexico_City');
          $final = new Carbon($actividad->termino_maniobra, 'America/Mexico_City');
          $tiempoTotal += $inicio->diffInSeconds($final, false);
          if($actividad->servicio->tipo == 'Carga')
          {
            $cargas += 1;
            $tiempoCargas += $inicio->diffInSeconds($final, false);
          }
          elseif($actividad->servicio->tipo == 'Descarga')
          {
            $descargas +=1;
            $tiempoDescargas += $inicio->diffInSeconds($final, false);
          }
          elseif($actividad->servicio->tipo == 'Trasbordo')
          {
            $trasbordos +=1;
            $tiempoTrasbordos += $inicio->diffInSeconds($final, false);
          }
      }

      $productividad->tiempoTotal = gmdate( "H:i:s" , $tiempoTotal);
      $productividad->tiempoCargas = gmdate( "H:i:s" , $tiempoCargas);
      $productividad->tiempoDescargas = gmdate( "H:i:s" , $tiempoDescargas);
      $productividad->tiempoTrasbordos = gmdate( "H:i:s" , $tiempoTrasbordos);
      $productividad->cargas = $cargas;
      $productividad->descargas = $descargas;
      $productividad->trasbordos = $trasbordos;
      $productividad->total = $trasbordos + $cargas + $descargas;;
            
      $diaSemana = Carbon::parse($produccion->last()->termino_maniobra);

      $lunes = Carbon::now()->startOfWeek();
      $domingo = Carbon::now()->endOfWeek();
      if( $diaSemana->between( $lunes , $domingo ) )
      {
        if($diaSemana->dayOfWeek == 1){
          $inicio = $produccion->last()->termino_maniobra;
          $semana = Coordinacion::whereDate("termino_maniobra", $inicio)->where('coordinador_id', $coordinador->id)->get();
        }else{
          $inicio = $diaSemana->subDays( $diaSemana->dayOfWeek - 1);
          $fin = $produccion->last()->termino_maniobra;
          $semana = Coordinacion::whereBetween("termino_maniobra", [$inicio, $fin])->where('coordinador_id', $coordinador->id)->get();
        }
        foreach( $semana as $dia ){
          $day = Carbon::parse($dia->final);
          for($i = $day->dayOfWeek; $i > 0; $i-- ){
            if($day->dayOfWeek == $i)
            {
              if($dia->coordinacion->servicio->tipo == 'Carga')
              {
                $week[$i-1]['cargas'] = $week[$i-1]['cargas'] + 1;
              }
              elseif($dia->coordinacion->servicio->tipo == 'Descarga')
              {
                $week[$i-1]['descargas'] = $week[$i-1]['descargas'] + 1;
              }
              elseif($dia->coordinacion->servicio->tipo == 'Trasbordo')
              {
                $week[$i-1]['trasbordos'] = $week[$i-1]['trasbordos'] + 1;
              }
            }
          }
        }

      }  
      
      $productividad->semana = $week;
      
      return view('pages.productividad.coordinadores.show', compact('coordinador', 'productividad'));
    }

    public function getDataCoordinador(Request $request, $coordinador)
    {
      $coordinador = User::find($coordinador);
      $fecha=Carbon::today()->format('Y-m-d');
      $fechas=explode("*",$request->date);

      if( count( $fechas ) > 1 )
        {
            $fechaInicio = date('Y-m-d', strtotime($fechas[0])) ;
            $fechaFinal = date('Y-m-d', strtotime($fechas[1])) ;
 
            $produccion = Coordinacion::whereBetween("fecha_servicio", [$fechaInicio, $fechaFinal])
                          ->where('coordinador_id',$coordinador->id)
                          ->with(['servicio.cliente'])
                          ->get();
        }
        else if( $request->date )
        {
          $fecha = date('Y-m-d', strtotime( str_replace('/', '-', $request->date ) ) );
          $produccion = Coordinacion::whereDate("fecha_servicio", $fecha)
              ->where('coordinador_id',$coordinador->id)
              ->with(['servicio.cliente'])
              ->get();
         
        }
        else
        {
          $produccion = Coordinacion::whereDate("fecha_servicio", $fecha)
              ->where('coordinador_id',$coordinador->id)
              ->with(['servicio.cliente'])
              ->get();

              
        }

      
      foreach($produccion as $servicio)
      {
        $inicio = new Carbon($servicio->inicio, 'America/Mexico_City');
        $date_humans=Date::instance($servicio->created_at)->format('F j, Y');
        $servicio['date_humans'] = $date_humans;
        if($servicio->inicio && $servicio->final){
          $final  = new Carbon($servicio->final, 'America/Mexico_City');
          $duracion = $inicio->diffInSeconds($final, false); 
          $servicio['duracion'] = gmdate("H:i:s",$duracion) . ' Hrs.';
          $servicio['horaInicio'] = $inicio->format('H:i:s') . ' Hrs.';
          $servicio['horaFinal'] = $final->format('H:i:s') . ' Hrs.';
        }elseif(!$servicio->final){
          $servicio['duracion'] = '...';
          $servicio['horaInicio'] = $inicio->format('H:i:s') . ' Hrs.';
          $servicio['horaFinal'] = '...';
        }
      }

      //dd($produccion);
      
      return DataTables::of($produccion)->toJson();
    }

}
