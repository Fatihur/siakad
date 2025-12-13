<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_nilai_id')->constrained('buku_nilai')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_sikap', 5, 2)->nullable();
            $table->decimal('nilai_keterampilan', 5, 2)->nullable();
            $table->decimal('nilai_raport', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_nilai');
    }
};
