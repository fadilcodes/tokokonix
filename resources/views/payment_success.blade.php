<x-app-layout/>

<div class="flex flex-col items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-lg shadow-xl text-center border border-gray-200">
        <div class="mb-5 flex justify-center">
            <div class="rounded-full bg-green-100 p-5">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
        <p class="text-gray-600 mb-5">Terima kasih telah berbelanja di KONIX.</p>
        
        <div class="bg-gray-50 p-4 rounded mb-5 text-sm">
            <p>Kode Pesanan: <span class="font-bold">{{ $pesanan->kode }}</span></p>
            <p>Total Bayar: <span class="font-bold text-[#02b295]">Rp. {{ number_format($pesanan->jumlah_harga) }}</span></p>
        </div>

        <a href="{{ url('/') }}" class="bg-[#02b295] text-white px-6 py-2 rounded font-bold hover:bg-[#029a81] transition">
            Kembali Belanja
        </a>
    </div>
</div>

<x-footer></x-footer>