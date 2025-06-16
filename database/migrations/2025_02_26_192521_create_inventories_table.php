<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained()->onDelete('cascade');
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->integer('stok');
            $table->decimal('harga', 15, 2);
            $table->string('satuan')->default('pcs');
            $table->date('expired_date')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};