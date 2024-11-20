<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Table ini untuk menampung mahasiswa yang melakukan pengajuan IRS
 * mahasiwa_irs -> one to many dari table mahasiswa dan pengajuan irs
 * mahasiswa_irs_detail -> penghubung many to many antara table mahasiswa dan pengajuan irs
 */

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa_irs', function (Blueprint $table) {
            $table->id();
            $table->string('nim');            
            $table->string('status');
            $table->integer('semester');
            $table->timestamps();
        });
        Schema::create('mahasiswa_irs_detail', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_irs_id');
            $table->string('kode_irs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_irs');
        Schema::dropIfExists('mahasiswa_irs_detail');
    }
};
