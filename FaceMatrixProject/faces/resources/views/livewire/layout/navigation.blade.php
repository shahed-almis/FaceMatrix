<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<div>
    <nav class="container mx-auto p-6 " x-data="{ open: false }">
        <div class="flex items-center justify-between">
            <!-- Logo -->


            <!-- Desktop Links -->
            <div class="hidden md:flex gap-x-4 ">
                <a wire:navigate href="/"
                    class="text-white  font-bold transition-all hover:text-slate-500">{{ __('Staff Affairs') }}</a>
                <a href="/staff"
                    class="text-white font-bold transition-all hover:text-slate-500">{{ __('Employees') }}</a>
                <a wire:navigate href="/admins"
                    class="text-white font-bold transition-all hover:text-slate-500">{{ __('Admins Management') }}</a>
                <a wire:navigate href="/profile"
                    class="text-white font-bold transition-all hover:text-slate-500">{{ __('Account Management') }}</a>
                <a wire:navigate href="/language"
                    class="text-white font-bold transition-all hover:text-slate-500">{{ __('System languages') }}</a>
                <button id="logoutBtn" x-on:click.prevent="$dispatch('open-modal', 'logout-modal')"
                    class="text-white font-bold transition-all hover:text-slate-500">
                    {{ __('Logout') }}
                </button>
            </div>

            <!-- Hamburger Menu Button -->
            <button x-on:click="open = !open" class="md:hidden text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div>
                <img src="{{ asset('image/logo.png') }}" alt="logo" width="100px" height="100px">
            </div>
        </div>


        <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="open"
            class=" p-10 md:hidden absolute bg-slate-600  rounded-lg ">
            <a wire:navigate href="/"
                class="block text-white font-bold py-2 hover:text-slate-300">{{ __('Staff Affairs') }}</a>
            <a wire:navigate href="/staff"
                class="block text-white font-bold py-2 hover:text-slate-300">{{ __('Employees') }}</a>
            <a wire:navigate href="/admins"
                class="block text-white font-bold py-2 hover:text-slate-300">{{ __('Admins Management') }}</a>
            <a wire:navigate href="/profile"
                class="block text-white font-bold py-2 hover:text-slate-300">{{ __('Account Management') }}</a>
            <a wire:navigate href="/language"
                class="block text-white font-bold py-2 hover:text-slate-300">{{ __('System languages') }}</a>
            <button id="logoutBtn" x-on:click.prevent="$dispatch('open-modal', 'logout-modal')"
                class="block w-full text-start text-white font-bold py-2 hover:text-slate-300">
                {{ __('Logout') }}
            </button>
        </div>

    </nav>


    <x-modal name="logout-modal" :show="$errors->isNotEmpty()" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to log out?') }}
            </h2>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:click='logout' class="ms-3">
                    {{ __('Logout') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>


</div>
