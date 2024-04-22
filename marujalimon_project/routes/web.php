<?php

use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoluntarioController;
use App\Http\Middleware\CoordinadorMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', CoordinadorMiddleware::class])->group(function () {


    Route::get('/voluntarios', [VoluntarioController::class, 'index'])->name('voluntarios.index');
    Route::get('/voluntarios/create', [VoluntarioController::class, 'create'])->name('voluntarios.create');

    Route::get('/voluntarios/{voluntario}/coordinadores', [VoluntarioController::class, 'obtenerCoordinador']);
    Route::get('/voluntarios/{voluntario}/delegaciones', [VoluntarioController::class, 'obtenerDelegaciones']);
    Route::get('/voluntarios/{voluntario}/observaciones', [VoluntarioController::class, 'obtenerObservaciones']);
    Route::get('/voluntarios/{voluntario}/errores', [VoluntarioController::class, 'obtenerErrores']);
    Route::get('/voluntario/{voluntario}/horas', [VoluntarioController::class, 'renderizarVistaHoras'])->name('vistaHoras');

    Route::post('/voluntario/{voluntario}/horas', [VoluntarioController::class, 'calcularHoras'])->name('calcularHoras');
    Route::post('/voluntario/{voluntario}/horas-por-mes', [VoluntarioController::class, 'mostrarHorasPorMes'])->name('mostrarHorasPorMes');

    Route::post('/horas-por-mes', 'TuControlador@mostrarHorasPorMes')->name('horas.por.mes');



    Route::get('/voluntarios/{voluntario}', [VoluntarioController::class, 'show'])->name('voluntarios.show');

    Route::get('/table', [VoluntarioController::class,'listarVoluntariosTabla'])->name('listarVoluntariosTabla');
    Route::post('/voluntarios/create', [VoluntarioController::class, 'store'])->name('storeVoluntario');
    Route::get('/voluntario/{voluntario}/info', [VoluntarioController::class, 'getInfo'])->name('info');
    Route::get('/voluntario/{voluntario}/edit', [VoluntarioController::class, 'edit'])->name('voluntario.edit_form');
    Route::put('/voluntarios/{voluntario}', [VoluntarioController::class, 'update'])->name('voluntarios.update');

    Route::delete('/voluntarios/{voluntario}/delete', [VoluntarioController::class, 'destroy'])->name('voluntario.destroy');



Route::get('/graficos', [CoordinadorController::class, 'cargarVistaGraficos'])->name('graficos');





});

require __DIR__.'/auth.php';
