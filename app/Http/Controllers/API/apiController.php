<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class apiController extends Controller
{
    /**
     * Retornar a lista de usuarios
     * @return JsonResponse Retorna os Usuarios
     */

    public function index(): JsonResponse
    {
        //paginação
        $users = User::orderBy('id')->paginate(2);

        //Retornar os dados em formato do objeto status 200
        return response()->json([
            'status' => true,
            'users'=> "Listar Usuários",
            'senha'=> $users,
        ], 200);
    }

}
