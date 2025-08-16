<div>
    <div class="swiper-container container mx-auto flex justify-center items-center h-100">
        <div class="swiper mySwiper mt-10 p-4 overflow-hidden">
            <ul class="card-list swiper-wrapper">
                @foreach ($reconized as $reconize)
                    <li class="card-item swiper-slide py-5">
                        <a href="#"
                            class="card-link w-72 block bg-white px-10 py-20 text-center rounded-lg shadow-md border border-gray-200 hover:shadow-xl transition-all duration-300 select-none">

                            @if ($reconize->snapshot)
                                <img src="data:image/jpeg;base64,{{ base64_encode($reconize->snapshot) }}" alt="Snapshot"
                                    class="card-image w-full h-48 object-cover rounded-md mb-4">
                            @endif

                            <h2 class="name text-lg font-bold text-gray-800 mb-2">
                                {{ $reconize->face->name ?? 'Unknown' }}
                            </h2>

                            <div class="time-info text-sm text-gray-600 space-y-1">

                                <br>
                                <p>{{ __('Time') }}:

                                    {{ \Carbon\Carbon::parse($reconize->date_time)->format('h:i A') }}
                                </p>
                                <p>{{ __('Date') }}:
                                    {{ \Carbon\Carbon::parse($reconize->date_time)->format('Y-m-d') }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>


            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {

            breakpoints: {
                0: {
                    slidesPerView: 1
                },

                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                },
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

</div>
