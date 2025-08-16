<div x-data="{ showModal: false }">

    <form wire:submit.prevent="save" id="AddModal"
        class="fixed top-0 left-0 inset-0 bg-gray-500 bg-opacity-50 h-screen w-screen flex items-center justify-center"
        x-show="showModal" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="flex bg-white p-8 rounded-lg shadow-lg w-full  max-w-5xl items-center gap-8">


            <div class="w-full">
                <p class="text-center text-gray-600 mb-6">{{ __('Add Employee') }}</p>

                <div class="flex justify-around items-center">
                    <label for="firstName" class="text-sm ms-2">{{ __('First Name') }}</label>
                    <label for="lastName" class="text-sm ms-2">{{ __('Last Name') }}</label>
                </div>
                <div class="flex justify-between items-center gap-x-1">
                    <div class="flex flex-col">
                        <input type="text" id="firstName" wire:model.live="firstName"
                            class="bg-custom-gray rounded-3xl h-10 mt-4 w-full" placeholder="{{ __('First Name') }}">
                        @error('firstName')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <input type="text" id="lastName" wire:model.live="lastName"
                            class="bg-custom-gray rounded-3xl h-10 mt-4 w-full" placeholder="{{ __('Last Name') }}">
                        @error('lastName')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-between items-center gap-x-1">
                    <div class="flex flex-col">
                        <label for="email" class="flex justify-center items-center mt-4">{{ __('Email') }}</label>
                        <div class="flex flex-col">
                            <input type="email" id="email" wire:model.live="email"
                                class="bg-custom-gray rounded-3xl h-10 mt-4 w-full" placeholder="{{ __('Email') }}">
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label for="ref_no"
                            class="flex justify-center items-center mt-4">{{ __('Refrence number') }}</label>
                        <div class="flex flex-col w-full">
                            <input type="number" id="ref_no" wire:model.live="ref_no"
                                class="bg-custom-gray rounded-3xl h-10 mt-4 w-full"
                                placeholder="{{ __('Refrence number') }}">
                            @error('ref_no')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="flex justify-between items-center mt-3 gap-x-10">
                    <div class="flex flex-col w-full">
                        <label for="birth" class="text-sm text-center ms-2">{{ __('Date of Birth') }}</label>
                        <input type="date" id="birth" wire:model.live="birth"
                            class="bg-custom-gray rounded-3xl h-10 mt-4 w-full"
                            placeholder="{{ __('Date of Birth') }}">
                        @error('birth')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full">
                        <label for="gender" class="text-sm text-center ms-2">{{ __('Gender') }}</label>
                        <select id="gender" wire:model.live="gender"
                            class="bg-custom-gray rounded-3xl w-full h-10 mt-4">
                            <option value="" selected hidden>{{ __('Select Gender') }}</option>
                            <option value="male">{{ __('Male') }}</option>
                            <option value="female">{{ __('Female') }}</option>
                        </select>
                        @error('gender')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="flex justify-center gap-3 mt-5">
                    <button type="submit"
                        class="bg-slate-800 text-white hover:bg-gray-400 px-6 py-2 rounded-3xl font-semibold">
                        {{ __('Register') }}
                    </button>
                    <button type="button" @click="showModal = false"
                        class="bg-gray-500 text-white px-6 py-2 rounded-3xl font-semibold">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
            <div class="mt-6 flex flex-col justify-center items-center w-full">
                @if ($img)
                    <img src="{{ $img->temporaryUrl() }}" class=" w-52 my-2" alt="">
                @else
                    <img src="{{ asset('image/image.png') }}" class="w-20 my-2" alt="">
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



    <div class="flex justify-center items-center m-4">
        <div class="bg-slate-50 w-full rounded-lg">
            <div class="mt-4 ms-4 gap-4">
                <hr>
                <ul class="flex justify-around p-5 gap-6" wire:ignore>
                    <a wire:navigate href="/"
                        class="py-2 px-4 {{ Route::currentRouteName() === 'home' ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                        {{ __('Employees') }}
                    </a>
                    <a wire:navigate href="/reports"
                        class="py-2 px-4 {{ Route::currentRouteName() === 'reports' ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                        {{ __('Reports') }}
                    </a>
                    <a wire:navigate href="/attendance-tracker"
                        class="py-2 px-4 {{ Route::currentRouteName() === 'attendance.tracker' ? 'border-b-2 border-blue-500 text-blue-500' : '' }}">
                        {{ __('Attendance Tracker') }}
                    </a>


                </ul>
                <hr>
            </div>
            <div class="flex justify-between">
                <div class="flex justify-between p-4  gap-4">
                    <div class="flex justify-center items-center mt-6 rounded-3xl bg-slate-300 shadow-amber-100">
                        <div>
                            <button wire:click='changeOrder' class="pe-1 ps-5">{{ __('Order') }}</button>
                        </div>
                        <div class="ms-4">
                            <input type="text" wire:model.live='search' id="search"
                                placeholder="{{ __('Search') }}"
                                class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="fa-magnifying-glass"></i>
                            </span>
                        </div>
                    </div>
                </div>


            </div>
            <div class="flex justify-end items-end">
                <button x-on:click="showModal = true"
                    class="w-1/6 h-8 m-4 text-black text-sm font-semibold bg-custom2-gray rounded-3xl hover:bg-gray-200 transition-all duration-300">
                    {{ __('Register New Employee') }}
                </button>
            </div>
            <div class="mt-[20px] w-full border border-gray-300 overflow-auto max-h-[500px]">
                <table class="w-full border-collapse">
                    <thead class="border-solid bg-custom2-gray h-12">
                        <tr>
                            <th>{{ __('Employee ID') }}</th>
                            <th>{{ __('Employee Name') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($employees as $employee)
                            <tr class="border-b">
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->name }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>
