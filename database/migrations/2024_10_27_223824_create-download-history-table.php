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
        Schema::create('download_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('stock_path')->nullable();
            $table->text('stock_url')->nullable();
            $table->text('stock_image_preview')->nullable();
            $table->string('stock_name')->nullable();
            $table->string('stock_origin_param')->nullable();
            $table->integer('stock_origin')->nullable();
            $table->integer('stock_type')->nullable();
            $table->uuid('order_code')->unique()->nullable();
            $table->timestamp('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_history');
    }
};
