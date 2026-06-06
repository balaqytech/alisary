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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->morphs('submittable');
            $table->string('status')->default('new')->index();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->date('birthday')->nullable();
            $table->string('cv_path')->nullable();
            $table->json('answers')->nullable();
            $table->json('files')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
