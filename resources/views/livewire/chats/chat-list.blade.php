<section x-data={type:'all'}>
    <header class="border-b shadow-lg mb-1">
        <div class="flex justify-between px-4 py-2 items-center min-h-16 border-b">
            <div>
                Chats
            </div>
            <div @click="chatList = false" class="w-6 h-6 cursor-pointer" :class="chatList ? '' : 'hidden'">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="currentColor" class="bi bi-arrow-right"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                </svg>
            </div>
        </div>
        <div class="flex gap-3  px-4 border-b py-2">
            <div @click="type = 'all'" class="px-3 py-2 rounded-3xl hover:bg-blue-400 shadow-md cursor-pointer"
                :class="{ 'bg-blue-200': type == 'all' }">All</div>
            <div @click="type = 'deleted'" class="px-3 py-2 rounded-3xl hover:bg-blue-400 shadow-md cursor-pointer"
                :class="{ 'bg-blue-200': type == 'deleted' }">Deleted</div>
        </div>
    </header>
    <main class="" style="contain: content">
        <ul class="w-full space-y-2">
            <li class="px-1 lg:px-3 py-1 lg:py-2 flex w-full bg-gray-200 rounded-sm my-auto gap-2 items-center">
                <a href="" class="shrink-0">
                    <x-avatar class="w-10 h-10" />
                </a>
                <aside class="grid grid-cols-12 w-full items-center">
                    <a href="" class="col-span-11">
                        <div class="flex justify-between items-center ps-4">
                            <h3 class="text-lg font-semibold">mg mg</h3>
                            <small>5s</small>
                        </div>
                        <div class="flex items-center gap-1">
                            {{-- single tick  --}}
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                    <path
                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                </svg>
                            </span>
                            <p class="text-xs md:text-sm truncate">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum, voluptas.
                            </p>
                            <span class="px-2 rounded-full py-1.5 bg-blue-300 text-sm">5</span>
                        </div>
                    </a>
                    {{-- drop down  --}}
                    <div class=" col-span-1">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400  hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-three-dots-vertical w-7 h-7 text-gray-700"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')" wire:navigate>
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <button wire:click="logout" class="w-full text-start">
                                    <x-dropdown-link>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </button>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </aside>
            </li>
        </ul>
    </main>
</section>
