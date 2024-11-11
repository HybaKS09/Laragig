<?php

// Database migration for 'listings' table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('logo')->nullable();
            $table->string('company');
            $table->string('location');
            $table->string('email');
            $table->string('website');
            $table->string('tags');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listings');
    }
};
