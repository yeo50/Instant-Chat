<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Message;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chats.index');
    }
    public function send($id)
    {

        return view('chats.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        $meessagesToRead = Message::where('chat_id', $chat->id)->where('receiver_id', auth()->id())->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chats.show', ['chat' => $chat, 'id' => $chat->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
