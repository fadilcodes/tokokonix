<x-app-layout/>
<h1 class="text-[40px] font-bold p-10">Keranjang Belanja</h1>
<div class="flex p-10 gap-5">

    <div class="w-[70%] flex flex-col">
         @foreach($pesanan_details as $detail)
    
         <div class="flex items-center mb-5 border-b pb-5"> 
            
            <img src="{{ url('img/product') . '/' . $detail->barang->gambar }}" 
               alt="{{ $detail->barang->nama_barang }}" 
               class="w-[20%] h-full border border-3 pt-5 pb-5 rounded-[5%]">

            <div class="pl-10 w-full flex flex-col justify-between">
               
               <div class="flex justify-between items-start">
                   <h3 class="text-[30px] text-gray-800 truncate font-bold">
                      {{ $detail->barang->nama_barang }}
                   </h3>

                   <form action="{{ url('checkout/hapus') }}/{{ $detail->id }}" method="post">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-100 hover:bg-red-200 px-3 py-1 rounded transition" onclick="return confirm('Yakin mau hapus barang ini?');">
                            Hapus
                        </button>
                    </form>
               </div>
               
               <p class="text-gray-600 mb-2">Ukuran: <span class="font-bold">{{ $detail->ukuran }}</span></p>
               
               <div class="flex justify-between items-end mt-2">
                   <p class="text-[#02b295] font-bold text-xl">
                      Rp. {{ number_format($detail->jumlah_harga, 0, ',', '.') }}
                   </p>
                   
                   <div class="flex items-center gap-3 p-2 ">
                        <a href="{{ url('konfirmasi-check-out/kurang') }}/{{ $detail->id }}" 
                           class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded hover:bg-gray-100 font-bold text-gray-600 transition shadow-sm">
                           -
                        </a>

                        <span class="font-bold text-lg w-8 text-center">{{ $detail->jumlah }}</span>

                        <a href="{{ url('konfirmasi-check-out/tambah') }}/{{ $detail->id }}" 
                           class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded hover:bg-gray-100 font-bold text-gray-600 transition shadow-sm">
                           +
                        </a>
                   </div>
               </div>
               
            </div>

         </div>

         @endforeach
    </div>

    <div class="border border-[#8d8d8d] w-[30%] p-5 rounded-md h-fit sticky top-10">
        <h1 class="text-2xl font-bold mb-5 text-gray-800">Order Summary</h1>

        <div class="flex flex-col gap-4">
            @foreach($pesanan_details as $detail)
            <div class="flex justify-between items-start text-sm">
                
                <div class="w-[60%]">
                    <p class="font-bold text-gray-700">{{ $detail->barang->nama_barang }}</p>
                    <p class="text-gray-500 text-xs">
                        Size: {{ $detail->ukuran }} | Qty: {{ $detail->jumlah }}
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        {{ $detail->jumlah }} x Rp. {{ number_format($detail->barang->harga, 0, ',', '.') }}
                    </p>
                </div>

                <div class="font-semibold text-gray-800">
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

        <button id="pay-button" class="w-full bg-[#02b295] hover:bg-[#029a81] text-white font-bold py-3 rounded transition duration-300 shadow-lg transform hover:scale-105">
            Bayar Sekarang
        </button>
    </div>

</div>


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
  // Ambil tombol bayar
  var payButton = document.getElementById('pay-button');
  
  // Saat tombol diklik
  payButton.addEventListener('click', function () {
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    window.snap.pay('{{ $snapToken }}', {
      onSuccess: function(result){
        /* User berhasil bayar, arahkan ke controller buat update status */
        // Kita oper order_id dan status_code ke URL
        window.location.href = '/payment/finish?order_id=' + result.order_id + '&status_code=' + result.status_code + '&transaction_status=' + result.transaction_status;
      },
      onPending: function(result){
        /* Menunggu pembayaran */
        alert("Menunggu Pembayaran Anda!"); console.log(result);
      },
      onError: function(result){
        /* Pembayaran gagal */
        alert("Pembayaran Gagal!"); console.log(result);
      },
      onClose: function(){
        /* User tutup popup tanpa bayar */
        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
      }
    })
  });
</script>


<x-footer></x-footer>