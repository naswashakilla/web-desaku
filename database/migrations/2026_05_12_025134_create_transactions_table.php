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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']); // pemasukan atau pengeluaran
            $table->string('title');
            $table->integer('amount');
            $table->string('category');   // contoh: kebersihan, keamanan, kegiatan
            $table->text('description')->nullable();
            $table->date('date');
            $table->foreignId('user_id')->constrained(); // siapa yang input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
