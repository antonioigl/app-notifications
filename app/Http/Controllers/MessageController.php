<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Http\Requests\MessageCreateRequest;
use App\Http\Requests\MessageEditRequest;

class MessageController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(MessageCreateRequest $request)
    {
        Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'body' => $request->body,
        ]);

        return back()->with('flash', 'Tu mensaje fue enviado');

    }

    public function update(MessageEditRequest $request)
    {

        switch($request->submit_button) {

            case 'read':
                Message::setRead($request->recipients_id);
                break;

            case 'unread':
                Message::setUnread($request->recipients_id);
                break;

            case 'remove':
                Message::remove($request->recipients_id);
                return redirect()->route('recipient.index')->with('flash', 'Se ha eliminado satisfactoriamente');
        }

        return redirect()->route('recipient.index');
    }

    public function show(Message $message)
    {
        $message = auth()->user()->recipient()->findOrFail($message->id);
        $message->update(['read' => 1]);

        return view('show', compact('message'));
    }
}
