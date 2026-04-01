<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// - title (string)
 // - location (string)
 // - country (string) // in base al paese, si potrà mostrare la bandiera corrispondente
 // - description (text)
 // - user_id (foreign key)

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('country');
            $table->text('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_posts');
    }
};
