<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('clientes')->group(function(){
    Route::post('/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::put('/update', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/delete/{cliente_id}', [ClienteController::class, 'delete'])->name('clientes.delete');
    Route::get('/getAll', [ClienteController::class, 'getAll'])->name('clientes.getAll');
    Route::get('/findOne/{cliente_id}', [ClienteController::class, 'findOne'])->name('clientes.findOne');
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/form/{cliente_id?}', [ClienteController::class, 'form'])->name('clientes.form');
});

Route::prefix('pedidos')->group(function(){
    Route::post('/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/update', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/delete/{pedido_id}', [PedidoController::class, 'delete'])->name('pedidos.delete');
    Route::get('/getAll', [PedidoController::class, 'getAll'])->name('pedidos.getAll');
    Route::get('/findOne/{cliente_id}', [PedidoController::class, 'findOne'])->name('pedidos.findOne');
    Route::get('/status-pedidos', [PedidoController::class, 'getPedidoStatus'])->name('pedidos.getPedidoStatus');
    Route::get('/', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/form/{cliente_id?}', [PedidoController::class, 'form'])->name('pedidos.form');
    Route::get('/export-excel', [PedidoController::class, 'export'])->name('pedidos.export');
});
