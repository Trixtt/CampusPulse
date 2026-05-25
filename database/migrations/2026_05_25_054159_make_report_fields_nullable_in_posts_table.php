<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->string('category')
                ->nullable()
                ->change();

            $table->string('priority')
                ->nullable()
                ->change();

            $table->string('location')
                ->nullable()
                ->change();

            $table->decimal('latitude', 10, 7)
                ->nullable()
                ->change();

            $table->decimal('longitude', 10, 7)
                ->nullable()
                ->change();

        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            //
        });
    }
};