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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('copy_id')->nullable(true);
            $table->unsignedBigInteger('member_id')->nullable(true);
            $table->foreign('copy_id', 'records_copy_fk')->references('id')->on('copies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_id', 'records_memeber_fk')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date_take')->nullable(false); 
            $table->date('date_expect_return')->nullable(false); 
            $table->string('returned', 5)->nullable(false)->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
