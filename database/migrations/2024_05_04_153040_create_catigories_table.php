<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('catigories', function (Blueprint $table) {
            $table->id();
            $table->string('catigory');
            $table->integer('number');
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('catigories');
    }
};
