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
        Schema::create('copies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id')->nullable(true);
            $table->foreign('film_id', 'copies_film_fk')->references('id')->on('films')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('code')->nullable(false)->unique();
            $table->string('active', 5)->nullable(true)->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};
