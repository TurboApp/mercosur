<?php

namespace App\Http\Controllers;

use App\Notification;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('pages.notificaciones.index'); 
    }

    public function loadMore(Request $request)
    {
        $elements = 10;
        $limit = ceil($request->page * $elements);
        $offset = $limit - $elements;
        $notificaciones = Notification::where('receptor_id', Auth()->user()->id)
                            ->latest()
                            ->offset($offset)
                            ->limit($limit)
                            ->get();
        foreach($notificaciones as $noty)
        {
            $noty->receptor->perfil;
            $noty->emisor->perfil;
        }
        return $notificaciones->toJson(); 
    }

    public function readed(Request $request)
    {
        $notificacion = Notification::findOrFail($request->id);
        $notificacion->fill(['status'=>'readed'])->save();
        return $notificacion->toJson();
    }
    
    public function readedAll(Request $request)
    {
        $notificaciones = Notification::where('status' , 'no-read')->where('receptor_id', Auth()->user()->id)->update([ 'status' => 'readed' ]);
        return 'ok';
    }
    
    public function unread(Request $request)
    {
        $notificaciones = Notification::where([ [ 'status' , 'no-read' ], [ 'receptor_id', Auth()->user()->id ] ])->get();
        return $notificaciones->toJson();

    }
}
