<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\HorasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\VoluntarioController;
use App\Http\Controllers\VoluntarioLogeadoController;
use App\Http\Middleware\AdminOrCoordMiddleware;
use App\Http\Middleware\VoluntarioMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::middleware(AdminOrCoordMiddleware::class)->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/voluntarios', [VoluntarioController::class, 'index'])->name('voluntarios.index');
    Route::get('/voluntarios/create', [VoluntarioController::class, 'create'])->name('voluntarios.create');

    Route::get('/voluntarios/{voluntario}/coordinadores', [VoluntarioController::class, 'obtenerCoordinador']);
    Route::get('/voluntarios/{voluntario}/delegaciones', [VoluntarioController::class, 'obtenerDelegaciones']);
    Route::get('/voluntarios/{voluntario}/observaciones', [VoluntarioController::class, 'obtenerObservaciones']);
    Route::get('/voluntarios/{voluntario}/errores', [VoluntarioController::class, 'obtenerErrores']);
    Route::get('/voluntario/{voluntario}/horas', [VoluntarioController::class, 'renderizarVistaHoras'])->name('vistaHoras');

    Route::post('/voluntario/{voluntario}/horas', [VoluntarioController::class, 'calcularHoras'])->name('calcularHoras');
    Route::post('/voluntario/{voluntario}/horas-por-mes', [VoluntarioController::class, 'mostrarHorasPorMes'])->name('mostrarHorasPorMes');

    Route::post('/dashboard', [HorasController::class, 'mostrarHorasPorMes'])->name('totalHorasVoluntarios');



    Route::get('/voluntarios/{voluntario}', [VoluntarioController::class, 'show'])->name('voluntarios.show');


    Route::post('/voluntarios/create', [VoluntarioController::class, 'store'])->name('storeVoluntario');
    Route::get('/voluntario/{voluntario}/info', [VoluntarioController::class, 'getInfo'])->name('info');
    Route::get('/voluntarios/{voluntario}/edit', [VoluntarioController::class, 'edit'])->name('voluntario.edit_form');
    Route::put('/voluntarios/{voluntario}', [VoluntarioController::class, 'update'])->name('voluntarios.update');

    Route::delete('/voluntarios/{voluntario}/delete', [VoluntarioController::class, 'destroy'])->name('voluntario.destroy');

    Route::post('/voluntarios/horas/agregar', [HorasController::class, 'añadirHoras'])->name('horas.añadir');





    Route::post('/totalTareasPorMes', [TareasController::class, 'totalTareasPorMes'])->name('totalTareasPorMes');



    Route::get('/graficos', [CoordinadorController::class, 'cargarVistaGraficos'])->name('graficos');



    //RUTA DE COORDINADORES
    Route::get('/coordinador/create', [CoordinadorController::class, 'create'])->name('coordinador.create');

    Route::get('/coordinadores', [CoordinadorController::class, 'index'])->name('coordinadores.index');
    Route::get('/coordinador/{coordinador}', [CoordinadorController::class, 'show'])->name('coordinador.show');
    Route::post('/coordinador/store', [CoordinadorController::class, 'store'])->name('coordinador.store');



    Route::get('/coordinadores/{coordinador}', [CoordinadorController::class, 'edit'])->name('coordinador.edit_form');
    Route::put('/coordinadores/{coordinador}', [CoordinadorController::class, 'update'])->name('coordinador.update');
    Route::delete('/coordinadores/{coordinador}', [CoordinadorController::class, 'destroy'])->name('coordinador.destroy');





    //RUTA DE TAREAS
    Route::post('/voluntarios/tareas/agregar', [TareasController::class, 'agregar'])->name('tareas.agregar');


});



















Route::middleware(VoluntarioMiddleware::class)->group(function () {




    Route::get('/voluntario', [VoluntarioLogeadoController::class, 'index'])->name('voluntario_logeado.index');
    Route::get('/voluntario/{voluntario}/edit', [VoluntarioLogeadoController::class, 'edit'])->name('voluntario_logeado.edit');
    Route::put('/voluntario/{voluntario}', [VoluntarioLogeadoController::class, 'update'])->name('voluntario_logeado.update');
    Route::get('/voluntario/{voluntario}/calendario/', [CalendarioController::class, 'index'])->name('voluntario_logeado.calendario');
    Route::post('/voluntario/{voluntario}/calendario/', [CalendarioController::class, 'store'])->name('guardar_disponibilidad');





});

//RUTA PARA EL TESTEO

Route::get('/calendario', [TestingController::class, 'index'])->name('calendario.index');
Route::get('/obtener-tareas-lugar/{lugarId}', [TestingController::class, 'obtenerTareasLugar'])->name('calendario.obtenerTareasLugar');
Route::get('/modales', [TestingController::class,  'modal'])->name('modales');



require __DIR__ . '/auth.php';
