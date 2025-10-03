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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nip');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L','P']);
            $table->foreignId('jabatan_id')->constrained('jabatan')->restrictOnDelete();
            $table->foreignId('skpd_id')->constrained('skpd')->restrictOnDelete();
            $table->foreignId('unit_kerja_id')->constrained('unit_kerja')->restrictOnDelete();
            $table->string('nama_golongan')->nullable();
            $table->string('nama_pangkat')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->timestamps();

            $table->unique('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
