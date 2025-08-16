<div>
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
                            <button wire:click='toggleOrder' class="pe-1 ps-4">{{ __('Order') }}</button>
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
                <div>
                    <div class="flex justify-center items-center mt-6">
                        <form class="space-y-4">
                            <div class="flex justify-between items-center gap-4">
                                <div class="flex flex-col">
                                    <label for="start_date"
                                        class="text-sm  font-semibold text-gray-700">{{ __('Start Time') }}</label>
                                    <input type="datetime-local" wire:model.live="startDate" id="start_date"
                                        name="start_date" class="border border-gray-300  rounded-lg p-2 ">
                                </div>
                                <div class="flex flex-col ">
                                    <label for="end_date"
                                        class="text-sm font-semibold text-gray-700">{{ __('End Time') }}</label>
                                    <input type="datetime-local" wire:model.live="endDate" id="end_date"
                                        name="end_date" class="border border-gray-300 rounded-lg p-2 ">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    <div class="flex justify-center items-center mt-6 pl-4">
                        <button onclick="myprint('mytable')"
                            class="w-32 h-12 flex justify-center items-center bg-slate-100 rounded-2xl shadow-[3px_3px_8px_#091f3e,_-3px_-3px_8px_#0b316a] hover:shadow-none transition-all duration-300 px-4 py-2">
                            {{ __('Download PDF') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex gap-4 ps-6">
                <a wire:navigate href="/reports"
                    class="bg-slate-100 rounded-3xl flex items-center justify-center shadow-[3px_3px_8px_#091f3e,_-3px_-3px_8px_#0b316a] w-28 h-14 hover:shadow-none transition-all duration-300">
                    {{ __('Recognized') }}
                </a>
                <button wire:click="setDataType('unrecognized')"
                    class="bg-slate-100 rounded-3xl shadow-[3px_3px_8px_#091f3e,_-3px_-3px_8px_#0b316a] w-28 h-14 hover:shadow-none transition-all duration-300">
                    {{ __('Unrecognized') }}
                </button>
            </div>
            <div class="mt-[20px] w-full  overflow-auto max-h-[500px]">
                <table border="" id="mytable" class="mt-[20px] w-full border-collapse">
                    <thead class="border-solid bg-custom2-gray h-12">
                        <tr>
                            <th>{{ __('Refrence number') }}</th>
                            <th>{{ __('Employee Name') }}</th>
                            <th>{{ __('Check-in Time') }}</th>
                            <th>{{ __('Check-out Time') }}</th>
                            <th>{{ __('Face') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $attendance)
                            <tr class="border-b hover:bg-gray-100 text-center">
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $order == 'asc' ? $loop->iteration : $loop->count - $loop->iteration + 1 }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $attendance['enter']?->face?->name ?? __('Unknown') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $attendance['enter']?->date_time ? Carbon\Carbon::parse($attendance['enter']->date_time)->format('Y-m-d / H:i A') : __('No Data') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $attendance['leave']?->date_time ? Carbon\Carbon::parse($attendance['leave']->date_time)->format('Y-m-d / H:i A') : __('No Data') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $attendance['type'] == 'recognized' ? __('Known') : __('Unknown') }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function myprint(mytable) {

            var printdate = document.getElementById(mytable);
            newwin = window.open("");
            newwin.document.write(printdate.outerHTML);
            newwin.print();
            newwin.close();
        }
    </script>
</div>
