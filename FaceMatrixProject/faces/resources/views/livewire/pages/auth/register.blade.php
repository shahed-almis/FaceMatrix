<?php

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $phone = '';
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Admin::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'digits:10', 'unique:' . Admin::class],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($Admin = Admin::create($validated))));

        Auth::login($Admin);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>

    <div class="font-body bg-[url('/public/image/bg.png')] bg-cover bg-center min-h-screen">
        <div class="flex items-center justify-center min-h-screen">
            <form wire:submit="register"
                class="bg-slate-700 bg-opacity-10 p-8 rounded-xl shadow-xl max-w-sm w-full text-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-24 mx-auto mb-6" />
                <h2 class="text-2xl font-semibold text-gray-200 mb-4">تسجيل حساب جديد</h2>

                <div class="relative mb-4">
                    <i class="fas fa-Admin absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input wire:model="name" id="name"
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        type="text" name="name" required autofocus autocomplete="name"
                        placeholder="اسم المستخدم" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <div class="relative mb-4">
                    <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="number" wire:model="phone" id="phone" name="phone" required
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="09XXXXXXXX" />
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />

                <div class="relative mb-4">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input wire:model="email" id="email" type="email" name="email" required
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="البريد الالكتروني" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <div class="relative mb-6">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input wire:model="password" id="password" type="password" name="password" required
                        autocomplete="new-password"
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="رمز الدخول" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-900  transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                    تسجيل دخول
                </button>

                <a class="text-sm text-gray-100 cursor-pointer hover:text-blue-500" href="{{ route('login') }}"
                    wire:navigate>
                    هل لديك حساب؟
                </a>
            </form>
        </div>
    </div>
</div>
