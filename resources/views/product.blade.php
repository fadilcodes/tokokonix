<x-app-layout/> 
    <x-banner/>
    <div class="">
<!-- Baju Kaos -->
    <h1 class="flex items-center justify-center font-bold text-[30px] pt-10">T-Shirt</h1>
    <div class="flex flex-wrap gap-5 items-center justify-center m-5 ">
        <div class=" flex flex-wrap justify-center gap-5 p-10">
            <x-baju :barangs="$barangs" />
        </div>
    </div>

 <!-- Celana -->
    <h1 class="flex items-center justify-center font-bold text-[30px] pt-10">Jeans/jins</h1>
    <div class="flex flex-wrap gap-5 items-center justify-center m-5 ">
        <div class=" flex flex-wrap justify-center gap-5 p-10">
            <x-celana :barangs="$barangs" />
        </div>
    </div>

    <x-footer></x-footer>
