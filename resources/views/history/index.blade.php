<x-app-layout/>

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Pesanan</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Kode Pesanan</th>
                    <th class="py-3 px-6 text-left">Total Harga</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($pesanans as $key => $pesanan)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $key+1 }}</td>
                    <td class="py-3 px-6 text-left">{{ $pesanan->tanggal }}</td>
                    <td class="py-3 px-6 text-left font-bold">{{ $pesanan->kode }}</td>
                    <td class="py-3 px-6 text-left text-[#02b295] font-bold">
                        Rp. {{ number_format($pesanan->jumlah_harga + $pesanan->kode) }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($pesanan->status == 1)
                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Sudah Dibayar</span>
                        @else
                            <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ url('history') }}/{{ $pesanan->id }}" class="bg-gray-800 text-white py-1 px-3 rounded hover:bg-gray-600 transition text-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($pesanans->isEmpty())
            <div class="p-10 text-center text-gray-500">
                Belum ada riwayat pesanan. Yuk belanja dulu!
            </div>
        @endif
    </div>
</div>

<x-footer></x-footer>