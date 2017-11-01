<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Agente;

use Carbon\Carbon;
use Jenssegers\Date\Date;

use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function create(Request $request)
    {
        if($request->servicio !== "Descarga" && $request->servicio !== "Carga" && $request->servicio !== "Trasbordo")
        {
            return redirect('/servicio/nuevo');
        }
        
        $data = [
            "numero_servicio" => Servicio::getNumServicio(),
            "agentes" => Agente::get(),
            "hoy" => Date::instance(Carbon::now()),
            "tipo" => $request->servicio
        ];
        
        return view('pages.servicios.create', compact('data'));
    }
}
