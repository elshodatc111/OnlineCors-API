<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('mavzus', function (Blueprint $table) {
            $table->id();
            $table->integer('cours_id');
            $table->string('mavzu_name');
            $table->string('discription');
            $table->string('lenth');
            $table->integer('number');
            $table->string('video');
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('mavzus');
    }
};
