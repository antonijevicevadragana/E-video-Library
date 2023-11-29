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
        //
        Schema::table('records', function (Blueprint $table) {
            $table->unsignedBigInteger('finance_id')->nullable(true);
            $table->foreign('finance_id', 'record_fin_fk')->references('id')->on('finances')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('records', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign('record_fin_fk');
            
            // Remove the column
            $table->dropColumn('finance_id');
        });
    }
};
