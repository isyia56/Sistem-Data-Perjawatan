<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waran_jawatans', function (Blueprint $table) {
            $table->id();
            $table->integer('waran_id');
            $table->integer('ptj_id');
            $table->integer('aktiviti_id');
            $table->integer('pegawai_id');
            $table->integer('jawatan_gred_id');
            $table->string('butiran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waran_jawatans');
    }
};
