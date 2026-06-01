<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['sugestao', 'elogio', 'critica', 'duvida', 'outro'];

        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'categoria' => $this->faker->randomElement($categorias),
            'comentario' => $this->faker->sentences(3, true),
            'anonimo' => $this->faker->boolean(20), // 20% de chance de ser anônimo
            'user_id' => User::factory(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
