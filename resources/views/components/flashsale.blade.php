@props(['barangs' => []])
<div class="flex items-center gap-4 justify-center py-5" 
     x-data="countdown('2025-12-30 23:59:59')" 
     x-init="init()">

     <div class="md:flex ">
     <div>
        <h1 class="text-3xl italic p-5 text-cente"><span class="text-red-600 font-extrabold">FLASH⚡️</span> SALE</h1>
    </div>

    <div class="flex items-center gap-4 justify-center">
        <div class="bg-[#ff4d4d] text-white text-xl font-bold px-3 py-2 rounded shadow-md w-12 h-12 flex items-center justify-center">
        <span x-text="hours">00</span>
        </div>

        <span class="text-2xl font-bold text-gray-700">:</span>

        <div class="bg-[#ff4d4d] text-white text-xl font-bold px-3 py-2 rounded shadow-md w-12 h-12 flex items-center justify-center">
        <span x-text="minutes">00</span>
         </div>

        <span class="text-2xl font-bold text-gray-700">:</span>

        <div class="bg-[#ff4d4d] text-white text-xl font-bold px-3 py-2 rounded shadow-md w-12 h-12 flex items-center justify-center">
        <span x-text="seconds">00</span>
        </div>
    </div>
    </div>

    <script>
    function countdown(expiryDate) {
        return {
            expiry: new Date(expiryDate).getTime(),
            remaining: null,
            hours: '00',
            minutes: '00',
            seconds: '00',

            init() {
                this.updateTimer();
                setInterval(() => {
                    this.updateTimer();
                }, 1000);
            },

            updateTimer() {
                const now = new Date().getTime();
                const distance = this.expiry - now;

                if (distance < 0) {
                    // Kalau waktu habis, set jadi 00 semua
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                } else {
                    // Hitung Matematika Waktu
                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((distance % (1000 * 60)) / 1000);

                    // Tambahin angka '0' di depan kalau angkanya cuma satu digit (misal: 5 jadi 05)
                    this.hours = h < 10 ? '0' + h : h;
                    this.minutes = m < 10 ? '0' + m : m;
                    this.seconds = s < 10 ? '0' + s : s;
                }
            }
        }
    }
</script>

    </div>


    <div class="bg-[#ffe4e4]">
        <div class=" flex flex-wrap justify-center gap-2 sm:gap-5 pt-3 pb-3 sm:p-10">
            @foreach ($barangs as $barang)
                <x-product-card 
                    gambar="{{url('img/product')}}/{{ $barang->gambar }}"
                    nama="{{ $barang->nama_barang }}" 
                    :harga="$barang->harga" 
                    :isPromo="$barang->is_promo"
                    :id="$barang->id"
                    class="text-center items-center justify-center sm:w-fit "
                />
            @endforeach
        </div>
    </div>