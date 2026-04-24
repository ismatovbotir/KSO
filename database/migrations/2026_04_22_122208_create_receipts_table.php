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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('type')->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->text('data')->nullable();
            $table->string('status')->default('pending');
            $table->integer('retry_count')->default(0);
            $table->integer('code')->nullable();

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
