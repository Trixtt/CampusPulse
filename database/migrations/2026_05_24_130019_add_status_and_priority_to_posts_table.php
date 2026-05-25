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
        Schema::create('report_updates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('post_id')
                ->constrained('posts')
                ->onDelete('cascade');

            $table->string('status');

            $table->text('message');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->dropColumn('status');

            $table->dropColumn('priority');

        });
    }
};