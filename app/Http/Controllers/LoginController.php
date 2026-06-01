<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Foto;
use Illuminate\Support\Facades\Schema;
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
        // If the videos table doesn't exist (migrations not run), return an empty collection
        if (!Schema::hasTable('videos')) {
            $videos = collect();
        } else {
            $videos = \App\Models\Video::latest()->get();
        }

        return view('user.videos', compact('videos'));
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

public function galeria(\Illuminate\Http\Request $request)
    {
        $category = $request->get('category', null);
        $search = $request->get('search', null);
        
        // 1. Buscar fotos com filtros
        $fotos = Foto::when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })
        ->when($search, function ($query) use ($search) {
            return $query->where('description', 'like', '%' . $search . '%');
        })
        ->latest()
        ->get();
        
        // 2. Definir categorias disponíveis
        $categories = Foto::$categories ?? [
            'geral' => 'Geral',
            'apresentacoes' => 'Apresentações',
            'danca' => 'Dança',
            'musica' => 'Música',
            'poesia' => 'Poesia',
            'artes-visuais' => 'Artes Visuais',
            'bastidores' => 'Bastidores',
            'publico' => 'Público',
        ];
        
        // 3. Passar variáveis para a view
        return view('user.galeria', compact('fotos', 'categories', 'category', 'search')); 
    }
}