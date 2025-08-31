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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('buku_id');
            $table->unsignedInteger('pengunjung_id');
            $table->unsignedInteger('petugas_id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->date('tanggal_pengembalian')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat']);
            $table->integer('denda')->default(0);
            $table->text('keterangan')->nullable();
            $table->foreign('buku_id')->references('id')->on('bukus')->onDelete('cascade');
            $table->foreign('pengunjung_id')->references('id')->on('pengunjungs')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
