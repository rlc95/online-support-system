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
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id')->comment('Customer ID');
            $table->string('name')->comment('Customer Name');
            $table->string('email',191)->unique()->comment('Customer Email');
            $table->string('phone',10)->unique()->comment('Customer Phone Number');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `customers` comment 'Customers'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
