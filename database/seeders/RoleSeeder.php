<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        //Verifica se o papel Super Admin esta cadastrado caso contrário ele cadastrado esse papel
        if (!Role::where('name', 'Administrador')->first()) {
            $admin = Role::create([
                'name' => 'Administrador',
            ]);

            //Regra de permissão para o papel
            $admin->givePermissionTo([
                'index-user',
                'show-user',
                'create-user',
                'edit-user',
                'destroy-user',
                'index-role',
                'create-role',
                'edit-role',
                'destroy-role',
                'index-role-permission',
                'update-role-permission',
                'profile-user',
                'index-foto',
            ]);
        }

        //Verifica se o papel Professor esta cadastrado caso contrário ele cadastrado esse papel
        if (!Role::where('name', 'Professor')->first()) {
            $professor = Role::create([
                'name' => 'Professor',
            ]);

            //Regra de permissão para o papel
            $professor->givePermissionTo([
                'index-user',
                'show-user',
                'profile-user',
            ]);
        }

        //Verifica se o papel Aluno esta cadastrado caso contrário ele cadastrado esse papel
        if (!Role::where('name', 'Aluno')->first()) {
            $aluno = Role::create([
                'name' => 'Aluno',
            ]);

            //Regra de permissão para o papel            
            $aluno->givePermissionTo([]);
        }
    }
}
