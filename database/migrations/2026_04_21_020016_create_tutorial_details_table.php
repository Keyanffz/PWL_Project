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
    Schema::create('tutorial_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tutorial_id')->constrained('tutorials')->onDelete('cascade');
        $table->text('text')->nullable();
        $table->string('gambar')->nullable();
        $table->text('code')->nullable();
        $table->string('url')->nullable();
        $table->integer('order')->default(0);
        $table->enum('status', ['show', 'hide'])->default('show');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_details');
    }
};
