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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable(true);
            $table->foreign('member_id', 'finance_member_fk')->references('id')->on('members')->onUpdate('cascade');

            $table->unsignedBigInteger('record_id')->nullable(true);
            $table->foreign('record_id', 'finance_record_fk')->references('id')->on('records')->onUpdate('cascade');
            $table->integer('RentPrice')->nullable(false);
            $table->date('DatePaidRentPrice')->nullable(false);
            $table->string('deleyInDays')->nullable(true);
            $table->string('costLate')->nullable(true);
            $table->string('PaidCostLate',5)->nullable(true);
            $table->date('DatePaidCostLate')->nullable(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
