<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pesanans', function (Blueprint $table) {
        // Kita tambahin 'status' karena di screenshot lu belum ada
        $table->integer('status')->default(0); // 0 = keranjang
        
        // Kita tambahin 'kode' juga
        $table->string('kode')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('pesanans', function (Blueprint $table) {
        $table->dropColumn(['status', 'kode']);
    });
}
};
