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
        Schema::create('data_rights_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique()->index();
            $table->string('status')->default('new')->index();
            $table->string('request_type')->index();
            $table->string('email');
            $table->text('details')->nullable();
            $table->string('submitted_from_url')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rights_requests');
    }
};
