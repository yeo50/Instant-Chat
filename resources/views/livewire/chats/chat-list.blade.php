  <?php
  
  use App\Models\User;
  use App\Models\Chat;
  
  use Livewire\Volt\Component;
  
  new class extends Component {
      public $selectedChat;
      public $chats;
      public $id;
      protected $listeners = ['chatListUpdate' => '$refresh'];
      public function mount()
      {
          $this->chats = auth()->user()->chats;
      }
      public function test()
      {
          $user = auth()->user();
          $chats = $user->chats; // Fetch the chats
      }
  }; ?>
  <section class="overflow-hidden flex flex-col" x-data="{ type: 'all', id: @entangle('id') }" x-init="setTimeout(() => {
      conversationElement = document.getElementById('chat-' + id);
  
      if (conversationElement) {
          conversationElement.scrollIntoView({ 'behavior': 'smooth', 'block': 'start' })
      }
  }, 200);">

      <h1></h1>
      <header class="border-b shadow-lg mb-1 sticky top-0 z-10">
          <div class="flex justify-between px-4 py-2 items-center min-h-16 border-b">
              <div>
                  Chats
              </div>
              <div @click="chatList = false" class="w-6 h-6 cursor-pointer" :class="chatList ? '' : 'hidden'">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="currentColor"
                      class="bi bi-arrow-right" viewBox="0 0 16 16">
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
      <main class="overflow-y-scroll overflow-auto border" style="contain: content">
          <ul class="w-full space-y-2" style="contain: content">
              @foreach ($chats as $chat)
                  <li id="chat-{{ $chat->id }}" wire:key="{{ $chat->id }}"
                      class="px-1 lg:px-2 py-1 lg:py-2 flex w-full rounded-sm my-auto gap-2 items-center {{ $selectedChat?->id == $chat->id ? 'bg-gray-300/70' : '' }}">
                      <a href="{{ route('chats.show', $chat->id) }}" class="shrink-0">
                          <x-avatar class="w-10 h-10" />
                      </a>
                      <aside class="grid grid-cols-12 w-full items-center ps-1">
                          <a href="{{ route('chats.show', $chat->id) }}" class="col-span-11">
                              <div class="flex justify-between items-center ">
                                  <h3 class="text-lg font-semibold">{{ $chat->getReceiver()->name }}</h3>
                                  <small>{{ $chat->messages?->last()?->created_at->shortAbsoluteDiffForHumans() }}</small>
                              </div>
                              <div class="flex items-center gap-1">
                                  @if ($chat->messages?->last()?->sender_id === auth()->id())
                                      @if ($chat->isLastMessageRead())
                                          {{-- double tick  --}}
                                          <span>
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                  fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                  <path
                                                      d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                                  <path
                                                      d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                                              </svg>
                                          </span>
                                      @else
                                          {{-- single tick  --}}
                                          <span>
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                  fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                  <path
                                                      d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                              </svg>
                                          </span>
                                      @endif
                                  @endif
                                  <p class="text-xs md:text-sm truncate">
                                      {{ $chat->messages?->last()?->body ?? '' }}
                                  </p>
                                  @if ($chat->unReadCount() > 0)
                                      <span
                                          class="px-2 rounded-full py-1.5 bg-blue-300 text-sm ml-auto">{{ $chat->unReadCount() }}</span>
                                  @endif
                              </div>
                          </a>
                          {{-- drop down  --}}
                          <div class=" col-span-1">
                              <x-dropdown align="right" width="48">
                                  <x-slot name="trigger">
                                      <button
                                          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400  hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                              fill="currentColor"
                                              class="bi bi-three-dots-vertical w-7 h-7 text-gray-700"
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
              @endforeach
          </ul>
      </main>
  </section>
