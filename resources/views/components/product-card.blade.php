{{-- Kita definisikan variabel yang wajib (required) ada di komponen --}}
@props(['gambar', 'nama', 'harga', 'isPromo' => false, 'id' => 0])

<div {{ $attributes->merge(['class' => 'relative bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden']) }}>
    
    <div class="relative h-48 sm:h-64 overflow-hidden">
        @if ($isPromo)
            <span class="absolute top-2 left-2 px-3 py-1 text-xs font-bold text-white bg-red-600 rounded-full shadow-md z-10 uppercase">
                Flash Sale!
            </span>
        @endif
        
        <img src="{{ $gambar }}" alt="{{ $nama }}" class="h-full object-cover">
    </div>

    <div class="pt-5 space-y-2 items-center">
        <h3 class="md:text-xl  text-sm font-semibold text-gray-800 truncate hover:text-blue-600">
            <a href="#">{{ $nama }}</a>
        </h3>

        <p class="md:text-xl  text-base font-bold text-gray-900">
            {{ 'Rp' . number_format($harga, 0, ',', '.') }}
        </p>

         <a href="{{ url('pesan') }}/{{ $id }}">
            <x-button class="w-[80%] mb-4 mt-4 justify-center text-[10px] font-bold sm:text-sm hover:bg-[#02b295] text-center ">
                Beli Sekarang
            </x-button>
        </a>

    </div>
</div>