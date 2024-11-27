<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $photo;
    public function savePhoto()
    {
        $user = Auth::user();
        $validate = $this->validate([
            'photo' => 'required',
        ]);

        $photoPath = $this->photo->store('photos', 'public');
        $user->fill([
            'photo' => $photoPath,
        ]);
        $user->save();
        $this->dispatch('profile-updated', name: $user->name);
    }
}; ?>
<section>
    <header>Upload Photo</header>
    <form wire:submit="savePhoto" ">
       <div>
            <input type="file" wire:model="photo" class="my-2" name="photo"> <br>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

        <div class="flex items-center gap-4 mt-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
        </div>

    </form>
</section>
