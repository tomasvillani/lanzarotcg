<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntercambiosTable extends Migration
{
    public function up()
    {
        Schema::create('intercambios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('carta_id')->constrained('cartas')->onDelete('cascade'); 
            $table->foreignId('carta_ofrecida_id')->constrained('cartas')->onDelete('cascade'); 
            $table->date('fecha');
            $table->string('lugar');
            $table->enum('estado', ['p', 'a', 'r'])->default('p'); // p: pendiente, a: aceptado, r: rechazado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('intercambios');
    }
}
