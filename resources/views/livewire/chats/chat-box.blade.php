<section class="flex flex-col overflow-y-auto">
    <header class="flex items-center gap-4 px-2 lg:px-4  border-b sticky top-0 w-full py-2 z-10 bg-white">
        <a @click="chatList = true" href="#" class="shrink-0 md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
        </a>
        <x-avatar class="h-12 w-12" />
        <h2>{{ auth()->user()->name }}</h2>
    </header>
    {{-- body  --}}
    <main class=" flex-grow overflow-y-auto overscroll-contain overflow-x-hidden my-auto">


    </main>
    <footer class="shrink-0 z-10 bg-white inset-x-0 pb-1 px-2">
        <form action="" class="flex gap-3 ">
            <x-text-input class="grow" />
            <x-primary-button>send</x-primary-button>
        </form>
    </footer>
</section>
