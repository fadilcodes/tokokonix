@props(['barangs'])

@foreach ($barangs as $barang)
    @if(isset($barang->kategori) && strtolower($barang->kategori) == 'baju')
<div class="border border-3 pt-5 pb-5 rounded-[5%]">
         <div class="w-fit">
            <div class="relative h-48 sm:h-64 overflow-hidden">
                <img src="{{url('img/product')}}/{{ $barang->gambar }}" alt="{{ $barang->nama_barang }}" class="text-center items-center justify-center sm:w-[100%] h-full object-cover">
            </div>

            <div class="p-4 space-y-2 text-center items-center">
                <h3 class="md:text-xl  text-sm text-gray-800 truncate pt-3 font-bold text-[20px]">
                    {{ $barang->nama_barang }}
                </h3>

                <p class="md:text-xl  text-base text-gray-900">
                    {{ 'Rp' . number_format($barang->harga, 0, ',', '.') }}
                </p>

                <a href="{{ url('pesan') }}/{{ $barang->id }}">
                <x-button class="w-[80%] sm:w-full mt-3 justify-center text-[10px] font-bold sm:text-sm hover:bg-[#02b295] text-center ">
                    Beli Sekarang
                </x-button>
                </a>

            </div>
        </div>
</div>
   @endif
@endforeach