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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('category');           // pilihan atau isi sendiri
        $table->text('description');
        $table->string('location');           // lokasi kejadian
        $table->string('photo')->nullable();  // foto masalah
        $table->string('reporter_name');      // nama pelapor
        $table->string('reporter_phone')->nullable();
        $table->enum('status', ['pending', 'process', 'done'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
