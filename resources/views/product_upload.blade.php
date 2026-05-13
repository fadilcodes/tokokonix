<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Upload Produk</h1>
        <p class="text-gray-600 mb-6">Form ini untuk menambah produk baru (barang).</p>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 rounded-md bg-red-50 text-red-700 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 rounded-md bg-red-50 text-red-700 border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/product/upload') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_barang">Nama Produk</label>
                    <input
                        id="nama_barang"
                        name="nama_barang"
                        type="text"
                        value="{{ old('nama_barang') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#02b295]"
                        placeholder="Contoh: Kaos Hitam" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="harga">Harga</label>
                    <input
                        id="harga"
                        name="harga"
                        type="number"
                        min="0"
                        step="1"
                        value="{{ old('harga') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#02b295]"
                        placeholder="Contoh: 75000" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="stok">Stok</label>
                    <input
                        id="stok"
                        name="stok"
                        type="number"
                        min="0"
                        step="1"
                        value="{{ old('stok') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#02b295]"
                        placeholder="Contoh: 20" />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="keterangan">Keterangan</label>
                    <textarea
                        id="keterangan"
                        name="keterangan"
                        rows="4"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#02b295]"
                        placeholder="Deskripsi singkat produk">{{ old('keterangan') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="gambar">Gambar (jpg/png/jpeg, max 2MB)</label>
                    <input
                        id="gambar"
                        name="gambar"
                        type="file"
                        accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#02b295]" />
                    <p class="text-xs text-gray-500 mt-2">File akan disimpan ke folder <span class="font-mono">public/uploads</span>.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('product') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 rounded-md bg-[#02b295] hover:bg-[#029a81] text-white font-bold transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

