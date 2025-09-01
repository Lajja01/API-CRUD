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
        // create productr table
        Schema::create('products' , function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->string('description')->nullable;
            $table->decimal('price',10,2);
            $table->timestamps(); // create extra two table (created_at and updated_at)

            // Foreign key relation
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
