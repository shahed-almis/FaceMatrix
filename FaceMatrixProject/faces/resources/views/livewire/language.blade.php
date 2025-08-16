<div>

    <h1 class="text-6xl text-start font-semibold text-white p-10 mb-8">
        {{ __('System languages') }}
    </h1>
    <div class="flex items-center justify-center w-full ">
        <div class=" relative   bg-white  p-14 -m-6 rounded-2xl shadow-lg  text-center w-1/2 h-96 ">
            <div class="flex justify-around mb-10 w-full ">

                <button
                    class="lang-btn  flex items-center p-3     {{ $lang == 'ar' ? 'ring-2' : '' }} rounded-xl bg-white text-[#0a2854] shadow-lg transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-[7px_7px_20px_#091f3e,_-7px_-7px_20px_#0b316a]"
                    wire:click="changeLang('ar')">
                    <img src="https://flagcdn.com/w40/sa.png" alt="Arabic Flag" class="w-6 h-6 mr-2" />
                    العربية
                </button>
                <button
                    class="lang-btn flex items-center p-3 {{ $lang == 'en' ? 'ring-2' : '' }}  rounded-xl bg-white text-[#0a2854] shadow-lg transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-[7px_7px_20px_#091f3e,_-7px_-7px_20px_#0b316a]"
                    wire:click="changeLang('en')">
                    <img src="https://flagcdn.com/w40/gb.png" alt="English Flag" class="w-6 h-6 mr-2" />
                    English
                </button>
            </div>

            <div class="  flex justify-center gap-6 items-center w-full mt-56 -p-24:">
                <button
                    class="action-btn  bg-custom-gray text-black px-6 py-2 rounded-xl font-semibold transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg w-1/2 ">{{ __('Cancel') }}</button>
                <button
                    class="action-btn bg-slate-800 text-white px-6 py-2 rounded-xl font-semibold transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg w-1/2"
                    wire:click="save()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
