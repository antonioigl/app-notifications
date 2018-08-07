<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'recipient_id', 'body', 'read'];

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

    public static function setRead($messagesId)
    {
        return static::whereIn('id',$messagesId)->update(['read' => 1]);
    }

    public static function setUnread($messagesId)
    {
        return static::whereIn('id', $messagesId)->update(['read' => 0]);

    }

    public static function remove($messagesId)
    {
        return static::whereIn('id', $messagesId)->delete();

    }
}
