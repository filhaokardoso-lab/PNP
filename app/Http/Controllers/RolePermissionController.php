<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    //Listar  as permissões do perfil
    public function index(Role $role) 
    {
        //Verificar se o perfil é Admin, não permitir visualizar as permissões
        if($role->name == 'Admin'){

            //Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('role.index')->with('error', 'Permissão do Admin não pode ser acessada!');
        }    

        //Recuperar as permissões do perfil 
        $rolePermissions = DB::table('role_has_Permissions')
        ->where('role_id', $role->id)
        ->pluck('permission_id')
        ->all();

        //Recuperar as permissões
        $permissions = Permission::get();

        //Carregar a View
        return view('rolePermission.index', [
            'menu' => 'roles',
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
            'role' => $role,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        //Obter a permissão específica com base no ID fornecida em $request->permission
        $permission = Permission::find($request->permission);


        //Verificar se a permissão foi encontrada 
        if(!$permission){

            //Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('role-permission.update', ['role' => $role->id,
            'permission' => $request->permission])->with('error', 'Permissão não encontrada');
        }
        //Verificar se a Permissão ja está associada a um perfil
        if($role->permissions->contains($permission)){
        
        //Remover a permissão do perfil (bloquear)
        $role->revokePermissionTo($permission);
        
        //redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('role-permission.index', ['role' => $role->id])->with
        ('sucess', "Permissão bloqueada com sucesso!");
        }
        else{
            $role->givePermissionTo($permission);
            return redirect()->route('role-permission.index', ['role' => $role->id])->with('success', 'Permissão liberada com sucesso');
        }
    }
}
