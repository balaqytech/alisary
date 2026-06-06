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
        Schema::create('tender_listings', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('draft')->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 500)->nullable();
            $table->foreignId('contractor_id')->constrained('companies')->cascadeOnDelete();
            $table->longText('description');
            $table->timestamp('last_day_to_apply')->nullable()->index();
            $table->string('location')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->json('form_steps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_listings');
    }
};
