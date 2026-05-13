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
        Schema::table('due_payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('resident_name')->after('due_id');   // nama warga
            $table->string('resident_phone')->nullable()->after('resident_name'); // no HP
            $table->string('address')->nullable()->after('resident_phone'); // alamat/no rumah
        });
    }

    public function down(): void
    {
        Schema::table('due_payments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dropColumn(['resident_name', 'resident_phone', 'address']);
        });
    }
};
