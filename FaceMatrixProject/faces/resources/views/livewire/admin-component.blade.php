<div class="container mx-auto p-6">


    <button id="logoutBtn" x-on:click.prevent="$dispatch('open-modal', 'admin-modal')" wire:click="resetInputFields"
        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out mb-6 hover:opacity-80">
        {{ __('Add admin') }}
    </button>

    <div class="bg-white p-10 rounded-xl">


        <div class="mb-6">
            <input type="text" id="search" placeholder="{{ __('Press / to search') }}" wire:model.live='search'
                class="form-input w-full rounded-lg shadow-sm border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>



        <div class="rounded-lg shadow-lg p-6 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-sm uppercase text-center">
                        <th class="px-6 py-3 text-center font-medium"> {{ __('ID') }}</th>
                        <th class="px-6 py-3 text-center font-medium"> {{ __('name') }}</th>
                        <th class="px-6 py-3 text-center font-medium">{{ __('email') }}</th>
                        <th class="px-6 py-3 text-center font-medium">{{ __('phone') }}</th>
                        <th class="px-6 py-3 text-center font-medium">{{ __('photo') }}</th>
                        <th class="px-6 py-3 text-center font-medium">{{ __('control') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 text-center">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $admin->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $admin->phone }}</td>
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $admin->img) }}" alt="admin-image"
                                    class="w-12 h-12 rounded-full border-2 border-gray-300">
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if (!$admin->isMe())
                                    <button x-on:click.prevent="$dispatch('open-modal', 'admin-modal')"
                                        wire:click="edit({{ $admin->id }})"
                                        class=" bg-slate-600 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded-lg transition duration-300 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <button x-on:click.prevent="$dispatch('open-modal', 'delete-confirm-modal')"
                                        wire:click="setAdminToDelete({{ $admin->id }})"
                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg transition duration-300 ease-in-out ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                @else
                                    <a href="/profile" wire:navigate><span
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ __('Account Management') }}</span></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>

    <x-modal name="admin-modal" :show="$updateMode" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __($updateMode ? 'edit' : 'Add') }}
            </h2>
            <form class="mt-4">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('name') }}</label>
                    <input type="text" id="name"
                        class="form-input mt-1 block w-full rounded-lg shadow-sm border-gray-300" wire:model="name"
                        required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('email') }}
                    </label>
                    <input type="email" id="email"
                        class="form-input mt-1 block w-full rounded-lg shadow-sm border-gray-300" wire:model="email"
                        required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('phone') }}</label>
                    <input type="text" id="phone"
                        class="form-input mt-1 block w-full rounded-lg shadow-sm border-gray-300" wire:model="phone"
                        required>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('password') }}
                    </label>
                    <input type="password" id="password"
                        class="form-input mt-1 block w-full rounded-lg shadow-sm border-gray-300" wire:model="password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="img" class="block text-sm font-medium text-gray-700">{{ __('photo') }}</label>
                    <input type="file" id="img"
                        class="form-input mt-1 block w-full rounded-lg shadow-sm border-gray-300" wire:model="img">
                    <x-input-error :messages="$errors->get('img')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')" class="mr-3">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button wire:click.prevent="{{ $updateMode ? 'update' : 'store' }}">
                        {{ __($updateMode ? 'edit' : 'Add') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>


    <x-modal name="delete-confirm-modal" :show="$errors->isNotEmpty()" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Are you sure you want to remove this item?') }}
            </h2>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="mx-3">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button x-on:click="$dispatch('close')" wire:click.prevent="deleteConfirmed">
                    {{ __('Delete') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

</div>
