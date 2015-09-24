<?php

namespace Shipper\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('chat.chat');
    }

    public function sendMessage(Request $request)
    {
        try {
            \Event::fire(new \Shipper\Events\EventMensaje($request->input('message')));
            return \Response::json(array('success' => true));
        } catch (Exception $e) {
            return \Response::json(array('success' => false));
        }
    }

    public function buses()
    {
        return view('chat.chat');
    }

    
    public function updateLocation(Request $request)
    {
        try {
            \Event::fire(new \Shipper\Events\EventoCambioUbicacion($request->input('lat'), $request->input('lng')));
            return \Response::json(array('success' => true));
        } catch (Exception $e) {
            return \Response::json(array('success' => false));
        }
    }
}
