<x-app-layout/>
<div class="flex flex-col sm:flex-row p-10 gap-10">

    <div class="flex sm:w-1/2 items-center justify-center sm:justify-end">
            <img src="{{ url('img/product') . '/' . $barang->gambar }}" 
            alt="{{ $barang->nama_barang }}" 
            class="w-[80%] border border-3 pt-5  rounded-[5%]">
    </div>

    <div class="sm:w-1/2 items-center justify-center">

      <div class="flex flex-col justify-center">
            <h3 class="text-2xl sm:text-[40px] sm:text-left text-center text-gray-800 mb-5 truncate font-bold">
                    {{ $barang->nama_barang }}
            </h3>
            <p class="text-[25px] text-[#02b295] text-center sm:text-left font-bold pb-5">
                    {{ 'Rp. ' . number_format($barang->harga, 0, ',', '.') }}
            </p>
            <p class="text-center sm:text-left sm:text-xl  text-base text-gray-900 pb-5">
                    {{ $barang->keterangan }}
            </p>
      </div>

      <!-- Form Input -->
      <form action="{{ url('pesan') }}/{{ $barang->id }}" method="post">
        @csrf
        
        <div class="flex items-center justify-center pb-5 flex-col sm:items-start sm:justify-start">
            <h3 class="font-bold">Pilih Ukuran :</h3>
            <div class="flex gap-5">
                <label class="flex items-center justify-center">
                    <input type="radio" id="size_s" name="ukuran" value="S" class="m-2" required>S
                </label>
                <label class="flex items-center justify-center">
                    <input type="radio" id="size_l" name="ukuran" value="L" class="m-2">L
                </label>
                <label class="flex items-center justify-center">
                    <input type="radio" id="size_xl" name="ukuran" value="XL" class="m-2">XL
                </label>
                <label class="flex items-center justify-center">
                    <input type="radio" id="size_xxl" name="ukuran" value="XXL" class="m-2">XXL
                </label>
            </div>
        </div>
      
        <div class="flex sm:flex-col pb-6 items-center justify-center sm:items-start" x-data="{ count: 1 }">
            <label for="quantity" class="block mb-2 font-bold pr-3">Jumlah :</label>
            <div class="flex items-center">
                <button type="button" @click="count > 1 ? count-- : null" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-l font-bold text-gray-600 transition">-</button>
                
                <input type="number" name="quantity" x-model="count" class="w-16 h-10 text-center border-t border-b border-gray-300 focus:outline-none focus:ring-0" min="1" max="{{ $barang->stok }}" readonly>
                
                <button type="button" @click="count < {{ $barang->stok }} ? count++ : null" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-r font-bold text-gray-600 transition">+</button>
            </div>
        </div>

        <button type="submit" class="bg-[#02b295] text-white w-full py-3 rounded-md font-bold ">
            Checkout
        </button>
        
    </form>

    </div>
</div>

  <x-footer></x-footer>
    
