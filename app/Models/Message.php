<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;
    protected $fillable = [
        'chat_id',
        'sender_id',
        'receiver_id',
        'read_at',
        'sender_deleted_at',
        'receiver_deleted_at',
        'body'
    ];
}
