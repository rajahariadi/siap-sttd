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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('registration_id');

            $table->string('phone');
            $table->date('birthdate');
            $table->string('gender');
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('restrict');
            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('restrict');
            $table->foreign('status')->references('id')->on('status_students')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
