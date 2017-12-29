<?php

namespace App\Http\Controllers;

use App\Notification;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notificaciones = Notification::where('receptor_id', Auth()->user()->id)->latest()->paginate(15);
        //dd($notificaciones);
        return view('pages.notificaciones.index', compact('notificaciones')); 
    }
}
