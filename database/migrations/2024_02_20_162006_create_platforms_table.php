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
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->string('api_key')->nullable(); //future use
            $table->string('api_secret')->nullable(); //future use
            $table->string('access_token')->nullable(); //future use
            $table->string('callback_url')->nullable(); //future use
            $table->string('icon')->nullable(); // URL to the platform's icon
            $table->string('status')->default('active'); // active, inactive, suspended
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
