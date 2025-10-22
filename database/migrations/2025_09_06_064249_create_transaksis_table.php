<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('member_id')->constrained('members');
            $table->decimal('berat', 8, 2)->nullable(); // Tambahan
            $table->date('tanggal_masuk');
            $table->dateTime('estimasi_selesai')->nullable(); // Tambahan
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['pending', 'proses', 'selesai', 'diambil'])->default('pending');
            $table->decimal('total_harga', 10, 2)->default(0.00);
            $table->enum('dibayar', ['belum', 'sudah'])->default('belum');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
