<?php
use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Conversation;
use Livewire\Attributes\On;
new class extends Component {
    public $selectedChat;
}; ?>
<section class="flex flex-col overflow-y-auto">
    <header class="flex items-center gap-4 px-2 lg:px-4  border-b sticky top-0 w-full py-2 z-10 bg-white">
        <a @click="chatList = true" href="#" class="shrink-0 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
        </a>
        <x-avatar class="h-12 w-12" />
        <h2>{{ $selectedChat->getReceiver()->email }}</h2>
    </header>
    {{-- body  --}}
    <main class="flex flex-col gap-3 p-2.5 flex-grow overflow-y-auto overscroll-contain overflow-x-hidden my-auto">
        <div @class([
            'flex max-w-[85%]  md:max-w-[78%] w-auto gap-2 relative mt-2 ',
        ])>
            <div @class(['shrink-0'])>
                <x-avatar class="w-8 h-8" />
            </div>
            <div class="flex flex-col gap-2  p-2.5 rounded-xl text-black text-[15px] bg-[#f6f6f8fb]">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Animi, eius.</p>
                <div class="flex items-center ml-auto gap-2">
                    <p class="text-sm">12:34 pm</p>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check2" viewBox="0 0 16 16">
                            <path
                                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>

    </main>
    <footer class="shrink-0 z-10 bg-white inset-x-0 pb-1 px-2">
        <form action="" class="flex gap-3 ">
            <x-text-input class="grow" />
            <x-primary-button>send</x-primary-button>
        </form>
    </footer>
</section>
