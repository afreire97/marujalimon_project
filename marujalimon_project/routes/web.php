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

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    //dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');


    Route::resource('voluntarios', VoluntarioController::class);



    Route::post('/voluntario/{voluntario}/horas', [VoluntarioController::class, 'calcularHoras'])->name('calcularHoras');
    Route::post('/voluntario/{voluntario}/horas-por-mes', [VoluntarioController::class, 'mostrarHorasPorMes'])->name('mostrarHorasPorMes');

    //calcula el total de horas de los voluntarios por cada mes del año
    Route::post('/dashboard', [HorasController::class, 'mostrarHorasPorMes'])->name('totalHorasVoluntarios');

    Route::post('/voluntarios/horas/agregar', [HorasController::class, 'añadirHoras'])->name('horas.añadir');
    Route::post('/totalTareasPorMes', [TareasController::class, 'totalTareasPorMes'])->name('totalTareasPorMes');


    //RUTA DE COORDINADORES

    Route::resource('coordinadores', CoordinadorController::class);


    //RUTA DE TAREAS
    Route::post('/voluntarios/tareas', [TareasController::class, 'store'])->name('tareas.store');



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
Route::get('/modales', [TestingController::class, 'modal'])->name('modales');



require __DIR__ . '/auth.php';
