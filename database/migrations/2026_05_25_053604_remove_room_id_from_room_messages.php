<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_messages', function (Blueprint $table) {

            // Hapus foreign key dulu
            $table->dropForeign([
                'room_id'
            ]);

            // Baru hapus column
            $table->dropColumn(
                'room_id'
            );

        });
    }

    public function down(): void
    {
        Schema::table('room_messages', function (Blueprint $table) {

            $table->unsignedBigInteger(
                'room_id'
            )->nullable();

        });
    }
};