<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::create('fotos', function (Blueprint $table) {
        $table->id();
        $table->string('filename'); // nome do arquivo salvo
        $table->timestamps();
    });
}

};
