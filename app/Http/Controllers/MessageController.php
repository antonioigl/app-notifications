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

        $messages = auth()->user()->recipient()->whereIn('id', $request->recipients_id);

        switch($request->submit_button) {

            case 'read':
                $messages->update(['read' => 1]);
                break;

            case 'unread':
                $messages->update(['read' => 0]);
                break;

            case 'remove':
                $messages->delete();
                break;

        }

        return back();
    }
}