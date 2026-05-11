<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_announcements_table.php
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');           // judul pengumuman
            $table->text('content');           // isi pengumuman
            $table->string('category');        // contoh: 'umum', 'kesehatan', 'keamanan'
            $table->string('image')->nullable(); // foto opsional
            $table->boolean('is_published')->default(false); // draft atau publish
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // siapa yang buat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
