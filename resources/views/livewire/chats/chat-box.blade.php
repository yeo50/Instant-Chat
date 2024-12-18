<?php
use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Livewire\Attributes\On;
use App\Notifications\MessageSent;
use App\Notifications\MessageRead;
new class extends Component {
    public $selectedChat;
    public $body;
    public $loadedMessages;
    public int $skipper = 10;
    public function mount()
    {
        $this->loadMessages();
    }

    public function getListeners()
    {
        $auth_id = auth()->user()->id;
        return ["echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'];
    }
    public function broadcastedNotifications($event)
    {
        if ($event['type'] == MessageSent::class) {
            if ($event['chat_id'] == $this->selectedChat->id) {
                $this->dispatch('scroll-bottom');
                $newMessage = Message::find($event['message_id']);
                $this->loadedMessages->push($newMessage);
                $newMessage->read_at = now();
                $newMessage->save();

                // broadcast read
                $this->selectedChat->getReceiver()->notify(new MessageRead($this->selectedChat->id));
            }
        }
    }

    #[On('loadMore')]
    public function loadMore()
    {
        $this->skipper += 10;
        $this->loadMessages();
        $this->dispatch('posi');
    }
    public function sendMessage()
    {
        $this->validate([
            'body' => 'required|string',
        ]);

        $newMessage = Message::create([
            'chat_id' => $this->selectedChat->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedChat->getReceiver()->id,
            'body' => $this->body,
        ]);
        $this->reset('body');
        $this->dispatch('scroll-bottom');
        $this->loadedMessages->push($newMessage);

        $this->selectedChat->updated_at = now();
        $this->selectedChat->save();
        $this->dispatch('chatListUpdate');

        // broadcast
        $this->selectedChat->getReceiver()->notify(new MessageSent(auth()->user(), $this->selectedChat, $newMessage, $this->selectedChat->getReceiver()->id));
    }
    public function loadMessages()
    {
        $count = Message::where('chat_id', $this->selectedChat->id)->count();
        $this->loadedMessages = Message::where('chat_id', $this->selectedChat->id)
            ->skip($count - $this->skipper)
            ->take($this->skipper)
            ->get();
        return $this->loadedMessages;
    }
}; ?>
<section x-data="{ height: 0, chatEl: document.getElementById('chat'), markAsRead: null }" x-init="height = chatEl.scrollHeight;
$nextTick(() => {
    chatEl.scrollTop = height
});
Echo.private('users.{{ auth()->id() }}').notification((notification) => {
    if (notification['type'] == 'App\\Notifications\\MessageRead' && notification['chat_id'] == {{ $selectedChat->id }}) {
        markAsRead: true;
    }
});" class="flex flex-col overflow-y-auto">

    <header class="flex items-center gap-4 px-2 lg:px-4  border-b sticky top-0 w-full py-2 z-10 bg-white">
        <a @click="chatList = true" href="#" class="shrink-0 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
        </a>
        @if (isset($selectedChat->getReceiver()->photo))
            <x-avatar src="{{ asset('storage/' . $selectedChat->getReceiver()->photo) }}" class="w-8 h-8" />
        @else
            <x-avatar class="w-8 h-8" />
        @endif
        <h2>{{ $selectedChat->getReceiver()->email }}</h2>
    </header>
    {{-- body  --}}
    <main
        @posi.window="$nextTick(()=>{
            $el.offsetHeight;
          oldHeight = height;
          newHeight = $el.scrollHeight;
          if(oldHeight != newHeight) {
              $el.scrollTop += newHeight - oldHeight;
              height = newHeight;
              }})"
        @scroll="
        scrolTop= $el.scrollTop;
        if(scrolTop <= 0) {
            $wire.dispatch('loadMore');
        }"
        @scroll-bottom.window="$nextTick(()=>{ chatEl.scrollTop = chatEl.scrollHeight })" id="chat"
        class="flex flex-col gap-3 p-2.5 flex-grow overflow-y-auto overscroll-contain overflow-x-hidden my-auto">
        @if ($loadedMessages)
            @php
                $prevMessage = null;
            @endphp

            @foreach ($loadedMessages as $key => $loadedMessage)
                <div wire:key="{{ time() . $key }}" @class([
                    'flex max-w-[85%]  md:max-w-[78%] w-auto gap-2 relative mt-2 ',
                    'ml-auto' => $loadedMessage->sender_id === auth()->id(),
                ])>
                    @if ($key > 0)
                        @php
                            $prevMessage = $loadedMessages->get($key - 1);
                        @endphp
                    @endif

                    <div @class([
                        'shrink-0',
                        'invisible' => $prevMessage?->sender_id === $loadedMessage->sender_id,
                        'hidden' => $loadedMessage->sender_id === auth()->id(),
                    ])>
                        @if (isset($selectedChat->getReceiver()->photo))
                            <x-avatar src="{{ asset('storage/' . $selectedChat->getReceiver()->photo) }}"
                                class="w-8 h-8" />
                        @else
                            <x-avatar class="w-8 h-8" />
                        @endif
                    </div>
                    <div @class([
                        'flex flex-col gap-2 p-2.5 rounded-xl text-black text-[15px] ',
                        'bg-[#e6e6f8fb] rounded-bl-none' => !(
                            $loadedMessage->sender_id === auth()->id()
                        ),
                        'bg-blue-400 rounded-br-none' => $loadedMessage->sender_id === auth()->id(),
                    ])>
                        <p>{{ $loadedMessage->body }}</p>
                        <div class="flex items-center ml-auto gap-2">
                            <p class="text-xs">{{ $loadedMessage->created_at->format('g:h a') }}</p>
                            @if ($loadedMessage->sender_id === auth()->id())
                                <div x-data="{ markAsRead: @json($loadedMessage->isRead()) }">
                                    {{-- double tick  --}}
                                    <span x-cloak x-show="markAsRead">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                            <path
                                                d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                            <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                                        </svg>
                                    </span>
                                    {{-- single tick  --}}
                                    <span x-show="!markAsRead">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                            <path
                                                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                        </svg>
                                    </span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </main>
    <footer class="shrink-0 z-10 bg-white inset-x-0 pb-1 px-2">
        <form x-data="{ body: @entangle('body') }" @submit.prevent="$wire.sendMessage()" class="flex gap-3 ">
            <x-text-input autofocus wire:model="body" class="grow" />

            <x-primary-button x-bind:disabled="!body.trim()">send</x-primary-button>
        </form>
        @error('body')
            <p>{{ $message }}</p>
        @enderror
    </footer>
</section>
