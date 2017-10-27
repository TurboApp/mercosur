<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function inicio()
    {
        
        $resumen='Este es el resumen de '.auth()->user()->perfil->perfil;

        return view('pages.inicio.'.auth()->user()->perfil->perfil, compact('resumen'));
    }
}
