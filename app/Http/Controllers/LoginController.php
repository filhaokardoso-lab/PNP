<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Foto;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function fotos(){
        return view('user.fotos');
    }
    public function videos(){
        return view('user.videos');
    }
    public function comentarios(){
        return view('user.comentarios');
    }

    public function loginProcess(LoginRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Validar o usuário e a senha com as informações do banco de dados
        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        // Verificar se o usuário foi autenticado
        if(!$authenticated){
            // Redirecionar o usuário para página anterior "login", enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }

        // Obter o usuário autenticado
        $user = Auth::user();
        $user = User::find($user->id);

        // Verificar se a permissões é Administrador, tem acesso a todas as páginas
        if($user->hasRole('Administrador')){

        // O usuário tem todas as permissões
        $permissions = Permission::pluck('name')->toArray();
        }else{

            // Recuperar no banco de dados as permissões que o papel possui
            $permissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        }

        // Atribuir as permissões ao usuário
        $user->syncPermissions($permissions);


        // Redirecionar o usuário
        return redirect()->route('dashboard.index');
        

    }
    
    public function create()
    {

        // Carregar a VIEW
        return view('login.create');
    }

    public function store(UserRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Cadastrar no banco de dados na tabela usuários
        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            
            // Operação é concluída com êxito
            DB::commit();

        // Atribui o Perfil "Aluno"
        $user->assignRole("Aluno");


            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');

        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }


    public function destroy()
    {
        // Deslogar o usuário
        Auth::logout();

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }

public function galeria()
    {
        // 1. Buscar todas as fotos
        $fotos = Foto::all(); // Agora a classe Foto será reconhecida.
 
        // 2. Passar a variável $fotos para a view
        return view('user.galeria', compact('fotos')); 
    }
}