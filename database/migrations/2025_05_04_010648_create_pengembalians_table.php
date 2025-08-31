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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('peminjaman_id');
            $table->unsignedInteger('petugas_id');
            $table->dateTime('tanggal_pengembalian');
            $table->integer('denda')->default(0);
            $table->text('keterangan')->nullable();
            $table->foreign('peminjaman_id')->references('id')->on('peminjamen')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
