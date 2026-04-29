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
        Schema::create('pegawai_kontraks', function (Blueprint $table) {
            $table->id();
            $table->integer('pegawai_id');
            $table->date('tarikh_lantikan1');
            $table->date('tarikh_tamat1');
            $table->date('tarikh_lantikan2');
            $table->date('tarikh_tamat2');
            $table->date('tarikh_lantikan3');
            $table->date('tarikh_tamat3');
            $table->date('tarikh_lantikan4');
            $table->date('tarikh_tamat4');
            $table->date('tarikh_lantikan5');
            $table->date('tarikh_tamat5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_kontraks');
    }
};
