<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('alumni_id');
            $table->unsignedBigInteger('prodi_id');

            $table->string('nama')->nullable();
            $table->string('nim')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('jenis_instansi')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->string('skala_instansi')->nullable();
            $table->string('lokasi_instansi')->nullable();
            $table->string('kategori_profesi')->nullable();
            $table->string('profesi')->nullable();
            $table->string('token', 64)->unique()->nullable();

            $table->date('tanggal_lulus')->nullable();
            $table->date('tanggal_pertama_kerja')->nullable();

            $table->timestamps();

            $table->foreign('prodi_id')
                ->references('prodi_id')
                ->on('program_studi')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
