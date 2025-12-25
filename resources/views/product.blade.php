<x-app-layout/> 
    <x-banner/>
    <div class="">
<!-- Baju Kaos -->
    <h1 class="flex items-center justify-center font-bold text-[30px] pt-10 pb-5">T-Shirt</h1>
    <div class="flex flex-wrap sm:gap-5 items-center justify-center sm:m-5 ">
        <div class="flex flex-wrap justify-center gap-2 sm:gap-5 sm:p-10">
            <x-baju :barangs="$barangs" />
        </div>
    </div>

 <!-- Celana -->
    <h1 class="flex items-center justify-center font-bold text-[30px] pt-10 pb-5">Jeans/jins</h1>
    <div class="flex flex-wrap sm:gap-5 items-center justify-center sm:m-5 pb-10">
        <div class="flex flex-wrap justify-center gap-2 sm:gap-5 sm:p-10">
            <x-celana :barangs="$barangs" />
        </div>
    </div>

    <x-footer></x-footer>
