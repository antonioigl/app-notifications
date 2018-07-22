<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'body' => $request->body,
        ]);

        return back()->with('flash', 'Tu mensaje fue enviado');

    }

    public function update(Request $request)
    {
        if(is_null($request->recipients_id)){
            return back()->with('flash', 'No has seleccionado ningún mensaje');
        }
        //else

        $messages = Message::where('recipient_id', auth()->user()->id)->whereIn('id', $request->recipients_id);

        switch($request->submit_button) {

            case 'read':
                $messages->update(['read' => 1]);
                break;

            case 'unread':
                $messages->update(['read' => 0]);

        }

        return back();
    }
}
