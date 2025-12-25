<x-app-layout/>

<div class="max-w-7xl mx-auto min-h-screen">

    @if(!empty($pesanan) && $pesanan_details->count() > 0)

        <h1 class="text-2xl lg:text-[40px] font-bold p-4 lg:p-10 text-gray-800">Keranjang Belanja</h1>

        <div class="flex flex-col lg:flex-row p-4 lg:px-10 gap-5 lg:gap-10 items-start pb-20">

            <div class="w-full lg:w-[70%] flex flex-col">
                 @foreach($pesanan_details as $detail)
            
                 <div class="flex flex-col sm:flex-row items-center sm:items-start mb-5 border-b border-gray-200 pb-5 gap-4 sm:gap-0"> 
                    
                    <div class="w-full sm:w-[20%] flex justify-start">
                        <img src="{{ url('img/product') . '/' . $detail->barang->gambar }}" 
                           alt="{{ $detail->barang->nama_barang }}" 
                           class="w-32 h-32 sm:w-full sm:h-auto object-cover border rounded-lg shadow-sm">
                    </div>

                    <div class="w-full sm:pl-8 flex flex-col justify-between h-full">
                       
                       <div class="flex justify-between items-start gap-2">
                           <h3 class="text-lg sm:text-[25px] lg:text-[30px] text-gray-800 font-bold leading-tight">
                              {{ $detail->barang->nama_barang }}
                           </h3>

                           <form action="{{ url('checkout/hapus') }}/{{ $detail->id }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs sm:text-sm bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition whitespace-nowrap" onclick="return confirm('Yakin mau hapus barang ini?');">
                                    Hapus
                                </button>
                            </form>
                       </div>
                       
                       <p class="text-gray-500 text-sm sm:text-base mt-1 mb-4">Ukuran: <span class="font-bold text-gray-700">{{ $detail->ukuran }}</span></p>
                       
                       <div class="flex flex-wrap justify-between items-center mt-auto gap-3">
                           <p class="text-[#02b295] font-bold text-lg sm:text-xl">
                              Rp. {{ number_format($detail->jumlah_harga, 0, ',', '.') }}
                           </p>
                           
                           <div class="flex items-center gap-2 sm:gap-3">
                                <a href="{{ url('konfirmasi-check-out/kurang') }}/{{ $detail->id }}" 
                                   class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-md hover:bg-gray-50 text-gray-600 transition shadow-sm active:bg-gray-200">
                                   -
                                </a>

                                <span class="font-bold text-lg w-8 text-center text-gray-700">{{ $detail->jumlah }}</span>

                                <a href="{{ url('konfirmasi-check-out/tambah') }}/{{ $detail->id }}" 
                                   class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-md hover:bg-gray-50 text-gray-600 transition shadow-sm active:bg-gray-200">
                                   +
                                </a>
                           </div>
                       </div>
                    </div>
                 </div>
                 @endforeach
            </div>

            <div class="w-full lg:w-[30%] border border-gray-200 bg-gray-50 p-5 rounded-lg shadow-sm h-fit mt-5 lg:mt-0 lg:sticky lg:top-24">
                <h1 class="text-xl sm:text-2xl font-bold mb-5 text-gray-800">Order Summary</h1>

                <div class="flex flex-col gap-4 max-h-[300px] overflow-y-auto pr-1 custom-scrollbar">
                    @foreach($pesanan_details as $detail)
                    <div class="flex justify-between items-start text-sm">
                        <div class="w-[60%]">
                            <p class="font-bold text-gray-700 line-clamp-1">{{ $detail->barang->nama_barang }}</p>
                            <p class="text-gray-500 text-xs">
                                Size: {{ $detail->ukuran }} | Qty: {{ $detail->jumlah }}
                            </p>
                        </div>
                        <div class="font-semibold text-gray-800 whitespace-nowrap">
                            Rp. {{ number_format($detail->jumlah_harga, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <hr class="my-5 border-gray-300">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Total Harga</h3>
                    <h3 class="text-xl font-bold text-[#02b295]">
                        Rp. {{ number_format($pesanan->jumlah_harga, 0, ',', '.') }}
                    </h3>
                </div>

                <button id="pay-button" class="w-full bg-[#02b295] hover:bg-[#029a81] text-white font-bold py-3.5 rounded-lg transition duration-300 transform active:scale-95 lg:hover:scale-105">
                    Bayar Sekarang
                </button>
            </div>

        </div>

        {{-- SCRIPT MIDTRANS (Hanya dirender kalau ada barang) --}}
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
          var payButton = document.getElementById('pay-button');
          payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
              onSuccess: function(result){
                window.location.href = '/payment/finish?order_id=' + result.order_id + '&status_code=' + result.status_code + '&transaction_status=' + result.transaction_status;
              },
              onPending: function(result){ alert("Menunggu Pembayaran Anda!"); console.log(result); },
              onError: function(result){ alert("Pembayaran Gagal!"); console.log(result); },
              onClose: function(){ alert('Anda menutup popup tanpa menyelesaikan pembayaran'); }
            })
          });
        </script>

    @else
        {{-- TAMPILAN JIKA KERANJANG KOSONG --}}
        <div class="flex flex-col items-center justify-center h-[70vh] text-center px-4">
            <div class="bg-gray-100 p-6 rounded-full mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Belanja Kosong</h2>
            <p class="text-gray-500 mb-8">Kamu belum masukin barang apapun</p>
            <a href="{{ route('product') }}" class="px-6 py-3 bg-[#02b295] text-white font-bold rounded-lg hover:bg-[#029a81] transition ">
                Mulai Belanja
            </a>
        </div>

    @endif

</div>

<x-footer></x-footer>