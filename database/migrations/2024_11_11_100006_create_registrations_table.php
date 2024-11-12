<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('program_studi'); 
            $table->string('nim');
            $table->text('address'); 
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->enum('attendance_type', ['online', 'onsite']); 
            $table->integer('number_of_guests')->nullable();
            $table->string('toga_size');
            $table->string('file_path');
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
