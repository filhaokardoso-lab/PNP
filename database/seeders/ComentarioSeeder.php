<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder intentionally left empty so only real user-submitted
        // comments exist in the database. If you need fake comments
        // for development, uncomment the factory line below.

        // Comentario::factory(10)->create();
    }
}
