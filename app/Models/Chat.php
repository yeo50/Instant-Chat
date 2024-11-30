<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /** @use HasFactory<\Database\Factories\ChatFactory> */
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id'
    ];
    public function getReceiver()
    {
        if ($this->sender_id === auth()->id()) {
            return User::firstWhere('id', $this->receiver_id);
        } else {
            return User::firstWhere('id', $this->sender_id);
        }
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function isLastMessageRead(): bool
    {
        $userId = auth()->id();
        $message = $this->messages()->latest()->first();
        if ($message) {
            return $message->read_at !== null && $message->sender_id === $userId;
        }
    }
    public function unReadCount()
    {
        return $messages = $this->messages()->where('receiver_id', auth()->id())->whereNull('read_at')->count();
    }
}
