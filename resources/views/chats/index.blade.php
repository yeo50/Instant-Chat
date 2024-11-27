<x-app-layout>
    <div x-data="{ chatList: false }" x-init="updateChatList = () => {
        if (window.innerWidth > 768) {
            chatList = false;
        }
    };
    updateChatList();
    window.addEventListener('resize', updateChatList);"
        class="fixed flex inset-0 lg:top-16 lg:inset-x-2 m-auto shadow-lg border-t overflow-hidden bg-white">

        <div class="h-full  md:w-[320px] xl:w-[400px] shrink-0 overflow-y-auto"
            :class="chatList ? 'w-full' : 'max-md:hidden'">
            <livewire:chats.chat-list />
        </div>

        <div class="grid w-full h-full border-l-2 overflow-y-auto">
            <livewire:chats.chat-box />
        </div>

    </div>
</x-app-layout>
