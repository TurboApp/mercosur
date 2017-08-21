<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Destino;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function cliente(Request $request)
    {
        return Cliente::search($request->get('q'))->get();
    }

    public function destino(Request $request)
    {
        return Destino::search($request->get('q'))->get();
    }
}
