<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class NotificationController extends Controller
{
    public function index(){
      $usuarios=User::all();
      return view('pages.notificaciones.index',compact('usuarios'));
    }
}
