<?php
// Logic hitung jumlah keranjang (Simpel version langsung di view)
$keranjang_count = 0;
$pesanan_utama = null;

if(Auth::check()){
    $pesanan_utama = \App\Models\Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
    if(!empty($pesanan_utama)){
        $keranjang_count = \App\Models\PesananDetail::where('pesanan_id', $pesanan_utama->id)->count();
    }
}
?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center  h-16 ">

            <div class="flex items-center gap-10">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>

               <ul class="">
                <li class="">
                    <a href="{{ route('home') }}" class="pr-10 font-bold hover:text-[#01c2a2]">Home</a>
                    <a href="{{ route('product') }}" class="pr-10 font-bold hover:text-[#01c2a2]">Product</a>
                    <a href="{{ route('contact') }}" class="pr-10 font-bold hover:text-[#01c2a2]">Contact Us</a>
                </li>
            </ul>

           
        
            <!-- Settings Dropdown -->
            <div class="hidden  sm:flex sm:items-center sm:ms-6">
                @auth

                    <div class="flex items-center mr-5">
                        <a href="{{ !empty($pesanan_utama) ? url('checkout') . '/' . $pesanan_utama->id : url('product') }}" 
                           class="relative group">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-500 group-hover:text-[#01c2a2] transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            @if($keranjang_count > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                                    {{ $keranjang_count }}
                                </span>
                            @endif
                        </a>
                    </div>


                    <div class="flex items-center mr-5">
                        <a href="{{ url('history') }}" class="group relative" title="Riwayat Pesanan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-500 group-hover:text-[#01c2a2] transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    </div>

                    <x-dropdown alig="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-lg leading-4 font-bold text-[#01c2a2]  bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                             
                            <div><span class="text-gray-600">Hai, </span> {{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot> 

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-white p-2 pr-3 pl-3 rounded-md bg-[#01c2a2] hover:bg-[#01a68a] focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 border border-[#01c2a2] p-2 pr-3 pl-3 rounded-md hover:bg-[#e7fffb] focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >Register</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 ">

                <div class="px-4 mb-3">
                     <a href="{{ !empty($pesanan_utama) ? url('checkout') . '/' . $pesanan_utama->id : url('product') }}" class="flex items-center text-gray-600 hover:text-[#01c2a2]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Keranjang Belanja 
                        @if($keranjang_count > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $keranjang_count }}</span>
                        @endif
                     </a>
                </div>

                <div class="px-4 mb-3">
                     <a href="{{ url('history') }}" class="flex items-center text-gray-600 hover:text-[#01c2a2]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Belanja
                     </a>
                </div>

                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 ">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
