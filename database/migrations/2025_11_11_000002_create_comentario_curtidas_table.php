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
        Schema::create('comentario_curtidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comentario_id')->constrained('comentarios')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->timestamps();

            // Índices únicos - um usuário/IP por comentário
            $table->unique(['comentario_id', 'user_id']);
            $table->index('comentario_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario_curtidas');
    }
};
