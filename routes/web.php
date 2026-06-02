<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatrimonioController;

//Rotas públicas
// A rota raiz agora é o dashboard (index) — pública (acessa mesmo sem conta)
Route::get('/', [userController::class, 'painel'])->name('dashboard.index');

// Rota de exibição do formulário de login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');
Route::get('/create-user-login', [LoginController::class, 'create'])->name('login.create-user');
Route::post('/store-user-login', [LoginController::class, 'store'])->name('login.store-user');
Route::get('/galeria', [LoginController::class, 'galeria'])->name('user.galeria');

Route::get('/videos', [LoginController::class, 'videos'])->name('user.videos');
Route::get('/lista', [LoginController::class, 'lista'])->name('user.lista');
Route::get('/comentarios', [ComentarioController::class, 'index'])->name('user.comentarios');
Route::post('/comentarios', [ComentarioController::class, 'store'])->name('user.comentarios.store')->middleware('auth');
Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('user.comentarios.destroy')->middleware('auth');



Route::get('/users', [LoginController::class, 'users'])->name('user.users');
Route::get('/profile', [userController::class, 'profile'])->name('user.profile')->middleware('auth');


Route::get('/fotos', [FotoController::class, 'index'])->name('fotos.index');
Route::get('/fotos/upload', [FotoController::class, 'create'])->name('fotos.create')->middleware('auth');
Route::post('/fotos', [FotoController::class, 'store'])->name('fotos.store')->middleware('auth');
Route::delete('/fotos/{photo}', [FotoController::class, 'destroy'])->name('fotos.destroy')->middleware('auth');

use App\Http\Controllers\VideoController;

Route::get('/videos/upload', [VideoController::class, 'create'])->name('videos.create')->middleware('auth');
Route::post('/videos', [VideoController::class, 'store'])->name('videos.store')->middleware('auth');
Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy')->middleware('auth');



//Rotas privadas, necessita de login
Route::group(['middleware' => 'auth'], function () {
        //Gerar PDF
        Route::get('/generate-pdf-user', [userController::class, 'generatePdf'])->name('user.generate-pdf');

        // Rota /painel removida (agora '/' é o dashboard)

        //Rota para Pagina Home
        Route::get('/index-user', [userController::class, 'index'])->name('user.index')->middleware('permission:index-user');
        //Rota para Criar Usuário (Create)
        Route::get('/create-user', [userController::class, 'create'])->name('user.create')->middleware('permission:create-user');
        Route::post('/store-user', [userController::class, 'store'])->name('user.store')->middleware('permission:create-user');
        
        //Rota para Inventário de Patrimônios
        Route::get('/inventario', [PatrimonioController::class, 'inventory'])->name('patrimonios.inventory')->middleware('permission:index-patrimonio');
        Route::get('/inventario/export', [PatrimonioController::class, 'exportInventory'])->name('patrimonios.inventory.export')->middleware('permission:index-patrimonio');
        Route::post('/inventario/finalizar', [PatrimonioController::class, 'finalizeInventory'])->name('patrimonios.inventory.finalize')->middleware('permission:index-patrimonio');

        //Rota para Consultar Patrimônios
        Route::get('/patrimonios', [PatrimonioController::class, 'index'])->name('patrimonios.index')->middleware('permission:index-patrimonio');

        //Rota para Criar Patrimônio (Create)
        Route::get('/create-patrimonio', [PatrimonioController::class, 'create'])->name('patrimonios.create')->middleware('permission:create-patrimonio');
        Route::post('/store-patrimonio', [PatrimonioController::class, 'store'])->name('patrimonios.store')->middleware('permission:create-patrimonio');

        //Rota para Editar Patrimônio (Update)
        Route::get('/edit-patrimonio/{patrimonio}', [PatrimonioController::class, 'edit'])->name('patrimonios.edit')->middleware('permission:edit-patrimonio');
        Route::put('/update-patrimonio/{patrimonio}', [PatrimonioController::class, 'update'])->name('patrimonios.update')->middleware('permission:edit-patrimonio');
        Route::delete('/destroy-patrimonio/{patrimonio}', [PatrimonioController::class, 'destroy'])->name('patrimonios.destroy')->middleware('permission:destroy-patrimonio');
        
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
