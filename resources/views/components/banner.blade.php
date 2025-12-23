<!-- @props(['gambar', 'nama', 'harga', 'isPromo' => false]) -->

<div class="w-[100%] mx-auto overflow-hidden ">
    <div class="flex gap-1">
        {{-- Duplikasi konten untuk loop yang mulus --}}
        <div class="flex-none flex gap-5 animate-loop-scroll">
            <img src="{{ asset('img/banner/banner-1.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-2.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-3.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-4.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-5.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-6.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
        </div>
        <div class="flex-none flex gap-5 animate-loop-scroll" aria-hidden="true">
            <img src="{{ asset('img/banner/banner-1.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-2.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-3.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-4.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-5.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
            <img src="{{ asset('img/banner/banner-6.jpg')}}" class="md:w-[45vw] w-[100vw] flex-shrink-0 h-64 object-cover">
        </div>
    </div>
</div>