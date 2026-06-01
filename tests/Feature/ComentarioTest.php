<?php

namespace Tests\Feature;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComentarioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste: Exibir página de comentários
     */
    public function test_exibir_pagina_comentarios(): void
    {
        $response = $this->get('/comentarios');

        $response->assertStatus(200);
        $response->assertViewIs('user.comentarios');
    }

    /**
     * Teste: Criar novo comentário
     */
    public function test_criar_novo_comentario(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/comentarios', [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'categoria' => 'elogio',
            'comentario' => 'Este é um ótimo comentário com muitos caracteres',
            'anonimo' => false,
        ]);

        $response->assertRedirect('/comentarios');
        $this->assertDatabaseHas('comentarios', [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'categoria' => 'elogio',
        ]);
    }

    /**
     * Teste: Validação de comentário vazio
     */
    public function test_validar_comentario_obrigatorio(): void
    {
        $response = $this->post('/comentarios', [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'categoria' => 'elogio',
            'comentario' => '', // Vazio
        ]);

        $response->assertSessionHasErrors('comentario');
    }

    /**
     * Teste: Validação de e-mail inválido
     */
    public function test_validar_email_invalido(): void
    {
        $response = $this->post('/comentarios', [
            'nome' => 'João Silva',
            'email' => 'email-invalido',
            'categoria' => 'elogio',
            'comentario' => 'Um comentário válido com muitos caracteres',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Teste: Validação de categoria inválida
     */
    public function test_validar_categoria_invalida(): void
    {
        $response = $this->post('/comentarios', [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'categoria' => 'categoria-invalida',
            'comentario' => 'Um comentário válido com muitos caracteres',
        ]);

        $response->assertSessionHasErrors('categoria');
    }

    /**
     * Teste: Deletar comentário como autor
     */
    public function test_deletar_comentario_como_autor(): void
    {
        $user = User::factory()->create();
        $comentario = Comentario::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/comentarios/{$comentario->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('comentarios', ['id' => $comentario->id]);
    }

    /**
     * Teste: Não deletar comentário de outro usuário
     */
    public function test_nao_deletar_comentario_outro_usuario(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $comentario = Comentario::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->delete("/comentarios/{$comentario->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('comentarios', ['id' => $comentario->id]);
    }

    /**
     * Teste: Comentário anônimo
     */
    public function test_criar_comentario_anonimo(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/comentarios', [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'categoria' => 'sugestao',
            'comentario' => 'Este é um comentário anônimo com bastante texto',
            'anonimo' => true,
        ]);

        $this->assertDatabaseHas('comentarios', [
            'anonimo' => true,
        ]);
    }
}
