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
        Schema::create('game_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('session_id')->unique()->constrained('game_sessions')->onDelete('cascade'); 

            $table->integer('total_questions'); 
            $table->integer('correct_answers');
            $table->decimal('accuracy_score', 5, 2);

            $table->decimal('total_duration', 8, 3);
            $table->decimal('response_time_avg', 8, 3)->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_progress');
    }
};
