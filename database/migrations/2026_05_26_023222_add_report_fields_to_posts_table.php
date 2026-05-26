<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            if (!Schema::hasColumn('posts', 'type')) {

                $table->string('type')->nullable();

            }

            if (!Schema::hasColumn('posts', 'status')) {

                $table->string('status')->nullable();

            }

            if (!Schema::hasColumn('posts', 'priority')) {

                $table->string('priority')->nullable();

            }

            if (!Schema::hasColumn('posts', 'location')) {

                $table->string('location')->nullable();

            }

        });
    }

    public function down(): void
    {
        //
    }
};