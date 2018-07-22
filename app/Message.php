<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'recipient_id', 'body'];

    protected $casts = [
        'read' => 'boolean'
    ];

    // A message belongs to a sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // A message also belongs to a receiver
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
