<?php

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public $img = '';
    public string $photo_path = '';
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->photo_path = Auth::user()->img;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Admin::class)->ignore($user->id)],
        ];

        if (!empty($this->password)) {
            $rules['password'] = ['required', 'string', 'min:6'];
        }

        if (!empty($this->img)) {
            $rules['img'] = ['image', 'mimes:png,jpg,jpeg'];
        }

        $validatedData = $this->validate($rules);

        $user->fill($validatedData);

        if (!empty($this->img)) {
            $user->img = $this->img->store('admins', 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>




    <form wire:submit="updateProfileInformation" class=" flex justify-center items-center">

        <div
            class="bg-white md:flex gap-x-20 p-10 rounded-xl shadow-xl   text-center justify-center   min-w-xl  max-w-2xl  mx-auto overflow-hidden ">
            <div class="">
                <div class=" mb-4">
                    <p class="text-start p-2 text-black mb-4"> {{ __('Name') }} </p>
                    <input wire:model="name" id="name" name="name" type="text" required autofocus
                        autocomplete="name"
                        class="w-full  rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                {{-- <p class="text-left p-2 text-slate-600"> تغيير </p> --}}
                <div class="relative mb-4">
                    <p class="text-start p-2 text-black mb-4"> {{ __('Password') }} </p>
                    <input type="password" wire:model='password'
                        class="w-full  rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                {{-- <p class="text-left -p-4 text-slate-600"> تغيير </p> --}}

                <div class="relative mb-4">
                    <p class="text-start p-2 text-black mb-4">{{ __('Email') }} </p>

                    <input wire:model="email" id="email" name="email" type="email" required
                        autocomplete="username"
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                {{-- <p class="text-left -p-4 text-slate-600"> تغيير </p> --}}
                <div class="flex justify-between pt-2  gap-x-5">
                    <button type="reset"
                        class="action-btn bg-custom-gray text-black px-12 py-3 rounded-xl font-semibold transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                        {{ __('Cancel') }}</button>
                    <button
                        class="action-btn bg-slate-800 text-white px-12 py-3 rounded-xl font-semibold transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg"
                        type="submit"> {{ __('Save') }}</button>
                    <x-action-message class="mt-3 text-green-600" on="profile-updated">
                        {{ __('Saved') }}
                    </x-action-message>
                </div>
            </div>
            <div class="mt-10 flex flex-col items-center ">


                @if ($img)
                    <img src="{{ $img->temporaryUrl() }}" class=" w-52 my-2" alt="">
                @else
                    <img src="{{ Storage::url($photo_path) }}" class="w-52 my-2" alt="">
                @endif

                <div class="">
                    <label for="uploadFile1"
                        class="flex bg-gray-800 hover:bg-gray-700 text-white text-base px-5 py-3 outline-none rounded w-max cursor-pointer mx-auto font-[sans-serif]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 mr-2 fill-white inline" viewBox="0 0 32 32">
                            <path
                                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                data-original="#000000" />
                            <path
                                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                data-original="#000000" />
                        </svg>
                        {{ __('Change profile picture') }}
                        <div wire:loading wire:target="img">
                            <div role="status">
                                <svg aria-hidden="true"
                                    class="w-8 h-8 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <input type="file" wire:model='img' id='uploadFile1' class="hidden" />
                    </label>
                    <x-input-error :messages="$errors->get('img')" class="mt-2" />
                </div>
            </div>

        </div>
    </form>
</section>
