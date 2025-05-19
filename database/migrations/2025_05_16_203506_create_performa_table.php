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
        Schema::create('performa', function (Blueprint $table) {
            $table->id();

            // Foreign key
            $table->unsignedBigInteger('pengguna_id');
            $table->unsignedBigInteger('alumni_id');

            $table->enum('kerjasama_tim', [1, 2, 3, 4, 5]);
            $table->enum('keahlian_ti', [1, 2, 3, 4, 5]);
            $table->enum('bahasa_asing', [1, 2, 3, 4, 5]);
            $table->enum('komunikasi', [1, 2, 3, 4, 5]);
            $table->enum('pengembangan_diri', [1, 2, 3, 4, 5]);
            $table->enum('kepemimpinan', [1, 2, 3, 4, 5]);
            $table->enum('etos_kerja', [1, 2, 3, 4, 5]);

            // Teks bebas
            $table->text('kompetensi_kurang')->nullable();
            $table->text('saran_kurikulum')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('pengguna_id')->references('pengguna_id')->on('pengguna')->onDelete('cascade');
            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performa');
    }
};
