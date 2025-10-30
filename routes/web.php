<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;

//Rotas públicas
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');
Route::get('/create-user-login', [LoginController::class, 'create'])->name('login.create-user');
Route::post('/store-user-login', [LoginController::class, 'store'])->name('login.store-user');
Route::get('/galeria', [LoginController::class, 'galeria'])->name('user.galeria');

// Route::get('/fotos', [LoginController::class, 'fotos'])->name('user.fotos');
Route::get('/videos', [LoginController::class, 'videos'])->name('user.videos');
Route::get('/lista', [LoginController::class, 'lista'])->name('user.lista');
Route::get('/comentarios', [LoginController::class, 'comentarios'])->name('user.comentarios');
Route::get('/users', [LoginController::class, 'users'])->name('user.users');
Route::get('/profile', [userController::class, 'profile'])->name('user.profile');


Route::get('/fotos', [FotoController::class, 'index'])->name('fotos.index');
Route::post('/fotos', [FotoController::class, 'store'])->name('fotos.store');
Route::delete('/fotos/{photo}', [FotoController::class, 'destroy'])->name('fotos.destroy');



//Rotas privadas, necessita de login
Route::group(['middleware' => 'auth'], function () {
        //Gerar PDF
        Route::get('/generate-pdf-user', [userController::class, 'generatePdf'])->name('user.generate-pdf');

        //Rota para Pagina Home
        Route::get('/painel', [userController::class, 'painel'])->name('dashboard.index');

        //Rota para Pagina Home
        Route::get('/index-user', [userController::class, 'index'])->name('user.index')->middleware('permission:index-user');
        //Rota para Criar Usuário (Create)
        Route::get('/create-user', [userController::class, 'create'])->name('user.create')->middleware('permission:create-user');
        Route::post('/store-user', [userController::class, 'store'])->name('user.store')->middleware('permission:create-user');
        //Rota para Visualizar Usuário (Read)
        Route::get('/show-user/{user}', [userController::class, 'show'])->name('user.show')->middleware('permission:show-user');
        //Rota para Editar Usuário (Create)
        Route::get('/edit-user/{user}', [userController::class, 'edit'])->name('user.edit')->middleware('permission:edit-user');
        //Rota para Atualizar Usuário (Update)
        Route::put('/update-user/{user}', [userController::class, 'update'])->name('user.update')->middleware('permission:edit-user');
        //Rota para Excluir Usuário (Delete)
        Route::delete('/destroy-user/{user}', [userController::class, 'destroy'])->name('user.destroy')->middleware('permission:destroy-user');

        //Listar Perfil
        Route::get('/index-role', [RoleController::class, 'index'])->name('role.index')->middleware('permission:index-role');
        Route::get('/create-role', [RoleController::class, 'create'])->name('role.create')->middleware('permission:create-role');
        Route::post('/store-role', [RoleController::class, 'store'])->name('role.store')->middleware('permission:create-role');
        Route::get('/edit-role/{role}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:edit-role');
        Route::put('/update-role/{role}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:edit-role');
        Route::delete('/destroy-role/{role}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:destroy-role');

        //Permissão do perfil
        Route::get(
                '/index-role-permission/{role}',
                [RolePermissionController::class, 'index']
        )->name('role-permission.index')->middleware('permission:index-role-permission');

        Route::get(
                '/update-role-permission/{role}',
                [RolePermissionController::class, 'update']
        )->name('role-permission.update')->middleware('permission:update-role-permission');
});
