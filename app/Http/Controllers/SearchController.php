<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Servicio;
use App\LineasTransporte;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function cliente(Request $request)
    {
        return Cliente::search($request->get('q'))->get();
    }

    public function destino(Request $request)
    {
        return Servicio::search($request->get('q'))->distinct()->select('destino')->get();
    }

    public function transporte(Request $request)
    {
        return LineasTransporte::search($request->get('q'))->get();
    }
}
