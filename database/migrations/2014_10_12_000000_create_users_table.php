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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->string('designation')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('role',['candidate','admin','employer'])->default('candidate');
            $table->text('summary')->nullable();
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_website')->nullable();
            $table->text('company_description')->nullable();
            $table->text('company_address')->nullable();
            $table->text('company_location')->nullable();
            $table->string('company_size')->nullable();
            $table->string('cv')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
