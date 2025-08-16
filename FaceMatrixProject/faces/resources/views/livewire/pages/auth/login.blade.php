<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class="font-body bg-[url('/public/image/bg.png')] bg-cover bg-center min-h-screen">
        <div class="flex items-center justify-center min-h-screen">
            <form wire:submit="login"
                class="bg-slate-700 bg-opacity-10 p-8 rounded-xl shadow-xl max-w-sm w-full text-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-24 mx-auto mb-6" />
                <h2 class="text-2xl fomt-bold  text-gray-200 mb-4 ">تسجيل الدخول</h2>
                <h2 class="text-2xl font-bold  text-gray-200 mb-4"> تسجيل الدخول إلى حساب </h2>


                <div class="relative mb-4">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input wire:model="form.email" id="email"
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        type="email" name="email" required autofocus placeholder="البريد الالكتروني" />
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                <div class="relative mb-6">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input wire:model="form.password" id="password"
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="رمز الدخول" />
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                <button
                    class="w-full py-2 px-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-900  transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
                    onclick="login()">
                    تسجيل الدخول
                </button>


                <div> <a class="block w-full py-2 px-4 bg-blue-200 text-black font-bold rounded-full hover:bg-green-600  transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 mt-4"
                        wire:navigate href="{{ route('register') }}">
                        تسجيل حساب جديد
                    </a></div>

            </form>
        </div>
    </div>
</div>
