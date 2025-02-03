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
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id')->comment('Ticket ID');
            $table->integer('cui')->unsigned()->comment('Customer ID');
            $table->index('cui');
            $table->foreign('cui')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
            $table->text('remrk')->comment('Problem Description');
            $table->string('ref')->unique()->comment('reference Number');
            $table->tinyInteger('sts')->comment('Status (1=Resolved/2=Pending/0=Inactive');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `tickets` comment 'Teckets'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
