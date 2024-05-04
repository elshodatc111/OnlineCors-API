<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->integer('techer_id');
            $table->integer('catigorie_id');
            $table->string('cours_name');
            $table->string('title');
            $table->string('discription');
            $table->string('price');
            $table->string('price_crm');
            $table->string('length');
            $table->integer('days');
            $table->string('image');
            $table->string('video');
            $table->timestamps();
        });
        
    }
    public function down(): void{
        Schema::dropIfExists('cours');
    }
};
