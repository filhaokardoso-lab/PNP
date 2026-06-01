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
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 100)->unique();
            $table->string('descricao');
            $table->string('categoria', 100);
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('numero_serie', 150)->nullable();
            $table->date('data_aquisicao');
            $table->decimal('valor_aquisicao', 15, 2);
            $table->string('setor_localizacao', 150)->nullable();
            $table->enum('situacao', ['Ativo', 'Inativo'])->default('Ativo');
            $table->string('imagem')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrimonios');
    }
};
