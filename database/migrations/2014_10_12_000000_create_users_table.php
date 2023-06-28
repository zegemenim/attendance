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
            $table->string('name')->default("Bilinmiyor");
            $table->string('username')->comment("TC Kimlik No");
            $table->string('room')->nullable();
            $table->string('floor_id')->nullable();
            $table->string('study_room')->nullable();
            $table->integer('rank')->default(300)->comment("300->Öğrenci, 200->Öğretmen, 100->Yönetim, 0->Admin");
            $table->string('password');
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
