<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'daniel@email.com')->first()) {
            $admin = User::create([
                'name' => 'daniel',
                'email' => 'daniel@email.com',
                'password' => Hash::make('123456', ['rounds' => 12]),
                'image' => null,
            ]);

            // Atribuir papel para o usuário
            $admin->assignRole('Administrador');
        }
        
        if (!User::where('email', 'professor@email.com')->first()) {
            $professor = User::create([
                'name' => 'professor',
                'email' => 'professor@email.com',
                'password' => Hash::make('123456', ['rounds' => 12]),
                'image' => null,
            ]);

            // Atribuir papel para o usuário
            $professor->assignRole('Professor');
        }
        
        if (!User::where('email', 'aluno@email.com')->first()) {
            $aluno = User::create([
                'name' => 'aluno',
                'email' => 'aluno@email.com',
                'password' => Hash::make('123456', ['rounds' => 12]),
                'image' => null,
            ]);

            // Atribuir papel para o usuário
            $aluno->assignRole('Aluno');
        }
    }
}
