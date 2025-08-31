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
        Schema::create('bukus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_buku')->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->integer('tahun_terbit');
            $table->unsignedInteger('kategori_id'); // foreign key manual
            $table->integer('jumlah');
            $table->integer('tersedia');
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable();
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
