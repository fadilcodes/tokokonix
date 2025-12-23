<x-app-layout/>

<div class="container mx-auto p-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan <span class="text-[#02b295]">#{{ $pesanan->kode }}</span></h1>
        <a href="{{ url('history') }}" class="text-gray-600 hover:text-gray-900 font-bold">&larr; Kembali</a>
    </div>

    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-5" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">Pesanan ini telah lunas dan sedang diproses.</span>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
        
        @foreach($pesanan_details as $detail)
        <div class="flex items-center border-b border-gray-100 py-4">
            <img src="{{ url('img/product') . '/' . $detail->barang->gambar }}" 
                 alt="{{ $detail->barang->nama_barang }}" 
                 class="w-20 h-20 object-cover rounded-md border">
            
            <div class="ml-5 flex-1">
                <h3 class="text-lg font-bold text-gray-800">{{ $detail->barang->nama_barang }}</h3>
                <p class="text-sm text-gray-500">Ukuran: {{ $detail->ukuran }} | Jumlah: {{ $detail->jumlah }} pcs</p>
            </div>
            
            <div class="text-right">
                <p class="text-[#02b295] font-bold">Rp. {{ number_format($detail->jumlah_harga) }}</p>
            </div>
        </div>
        @endforeach

        <div class="flex justify-end mt-6">
            <div class="text-right">
                <p class="text-gray-600">Total Harga:</p>
                <h2 class="text-3xl font-bold text-gray-800">Rp. {{ number_format($pesanan->jumlah_harga) }}</h2>
            </div>
        </div>

    </div>
</div>

<x-footer></x-footer>