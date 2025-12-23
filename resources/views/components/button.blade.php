{{-- Kita definisikan variabel $attributes dan $slot --}}
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 
    py-2 border border-transparent rounded-md font-semibold text-md text-white bg-[#01c2a2]  
    uppercase tracking-widest hover:bg-[#019f85] active:bg-blue-700 focus:outline-none 
    focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 
    transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>