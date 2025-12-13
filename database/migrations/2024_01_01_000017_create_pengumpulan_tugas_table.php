<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->text('konten')->nullable();
            $table->string('file_path')->nullable();
            $table->string('url_link')->nullable();
            $table->datetime('dikumpulkan_pada');
            $table->boolean('terlambat')->default(false);
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->datetime('dinilai_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
