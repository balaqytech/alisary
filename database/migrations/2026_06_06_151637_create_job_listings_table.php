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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('draft')->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 500)->nullable();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->longText('description');
            $table->string('type')->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->string('location')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->json('form_fields')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
