<x-app-layout/>
  <div class="flex p-10 gap-10">
    <div class="flex w-1/2 items-center justify-end">
        <img src="{{ url('img/product') . '/' . $barang->gambar }}" 
        alt="{{ $barang->nama_barang }}" 
        class="w-[80%] h-full border border-3 pt-5 pb-5 rounded-[5%]">
    </div>

    <div class="w-1/2">

      <div>
      <h3 class="text-[40px] text-gray-800 truncate pt-3 font-bold">
            {{ $barang->nama_barang }}
      </h3>
      <p class="text-[25px] text-[#02b295] font-bold pb-5">
            {{ 'Rp. ' . number_format($barang->harga, 0, ',', '.') }}
      </p>
      <p class="md:text-xl  text-base text-gray-900 pb-5">
            {{ $barang->keterangan }}
      </p>
      </div>

      <!-- Form Input -->
      <form action="{{ url('pesan') }}/{{ $barang->id }}" method="post">
        @csrf
        
        <div class="pb-5">
            <h3>Pilih Ukuran</h3>
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
      
        <div class="pb-6" x-data="{ count: 1 }">
            <label for="quantity" class="block mb-2 font-bold">Jumlah</label>
            <div class="flex items-center">
                <button type="button" @click="count > 1 ? count-- : null" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-l font-bold text-gray-600 transition">-</button>
                
                <input type="number" name="quantity" x-model="count" class="w-16 h-10 text-center border-t border-b border-gray-300 focus:outline-none focus:ring-0" min="1" max="{{ $barang->stok }}" readonly>
                
                <button type="button" @click="count < {{ $barang->stok }} ? count++ : null" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-r font-bold text-gray-600 transition">+</button>
            </div>
        </div>

        <button type="submit" class="bg-[#02b295] text-white px-5 py-2 rounded-md font-bold">
            Checkout
        </button>
        
    </form>

    </div>
  </div>

  <x-footer></x-footer>
    
