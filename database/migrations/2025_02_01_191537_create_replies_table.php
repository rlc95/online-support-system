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
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id')->comment('Replies ID');

            $table->integer('tki')->unsigned()->comment('Ticket ID');
            $table->index('tki');
            $table->foreign('tki')->references('id')->on('tickets')->onDelete('restrict')->onUpdate('cascade');
            
            $table->integer('cui')->unsigned()->comment('Customer ID');
            $table->index('cui');
            $table->foreign('cui')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
            
            $table->text('msg')->comment('messages');
            $table->timestamp('created_at')->nullable();
        });
        DB::statement("ALTER TABLE `replies` comment 'Replies'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
