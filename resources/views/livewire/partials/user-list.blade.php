  <?php
  
  use App\Models\User;
  use App\Models\Chat;
  
  use Livewire\Volt\Component;
  
  new class extends Component {
      public $users;
      public function mount()
      {
          $this->users = User::where('id', '!=', auth()->id())->get();
      }
      public function startChat($id)
      {
          $authenticatedUserId = auth()->id();
  
          $existedChat = Chat::where(function ($query) use ($authenticatedUserId, $id) {
              $query->where('sender_id', $authenticatedUserId)->where('receiver_id', $id);
          })
              ->orWhere(function ($query) use ($authenticatedUserId, $id) {
                  $query->where('sender_id', $id)->where('receiver_id', $authenticatedUserId);
              })
              ->first();
  
          if ($existedChat) {
              return redirect()->route('chats.show', $existedChat->id);
          }
          $newChat = Chat::create([
              'sender_id' => $authenticatedUserId,
              'receiver_id' => $id,
          ]);
  
          return redirect()->route('chats.show', $newChat->id);
      }
  };
  ?><section class="p-4">


      <table class="w-full">
          <thead>
              <tr>
                  <th class="text-start">No.</th>
                  <th class="text-start">User Name</th>
                  <th class="text-start">User Email</th>
                  <th class="text-start">User Photo</th>
                  <th class="text-start">Action</th>

              </tr>
          </thead>
          <tbody>
              @foreach ($users as $key => $user)
                  <tr>
                      <td class="text-start">{{ $key + 1 }}</td>
                      <td class="text-start">{{ $user->name }}</td>
                      <td class="text-start">{{ $user->email }}</td>

                      <td class="text-start">
                          @if ($user->photo)
                              <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                  class="block w-14 h-14 rounded-full">
                          @else
                              <x-avatar class="w-14 h-14" />
                          @endif
                      </td>
                      <td class="text-start">
                          <button wire:click="startChat({{ $user->id }})" class="text-blue-600 ">Message</button>
                      </td>

                  </tr>
              @endforeach
          </tbody>

      </table>
  </section>
