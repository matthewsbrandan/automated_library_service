<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageBookController;
use App\Http\Controllers\ManageReservationController;
use App\Http\Controllers\ManageDevolutionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
  Route::get('/', function () {
    return redirect('/home');
  });

  Route::get('/home',   [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/livros', [DashboardController::class, 'book'])->name('book.index');
  
  Route::name('manage.')->group(function (){
    Route::name('book.')->group(function (){
      Route::get('/gerenciar/livros', [ManageBookController::class, 'index'])->name('index');
      // [ ] [GET | JSON] pagination
      Route::post('/gerenciar/livros', [ManageBookController::class, 'store'])->name('store');
      Route::put('/gerenciar/livros/{id}', [ManageBookController::class, 'update'])->name('update');
      Route::delete('/gerenciar/livros/{id}', [ManageBookController::class, 'delete'])->name('delete');
    });

    Route::name('reservation.')->group(function (){
      Route::get('/gerenciar/reservas', [ManageReservationController::class, 'index'])->name('index');
      // [ ] [PUT | JSON] done
      // [ ] [PUT | JSON] denied
    });

    Route::name('devolution.')->group(function (){
      Route::get('/gerenciar/devolucoes', [ManageDevolutionController::class, 'index'])->name('index');
    });
  });
  
  Route::name('reservation.')->group(function (){
    Route::get('/reserva/solicitar/{book_id}', [ManageReservationController::class, 'requestReservation'])->name('request');
    Route::get('/reserva/recusar/{book_id}', [ManageReservationController::class, 'refuseReservation'])->name('refuse');
    Route::get('/reserva/separar/{transfer_id}/{rf_id}', [ManageReservationController::class, 'separateReservation'])->name('separate');
    Route::get('/reserva/gerar-token-de-coleta/{transfer_id}', [ManageReservationController::class, 'generateCollectToken'])->name('generate_token');
  });

  Route::get('/wallet', function () {
    return view('wallet');
  })->name('wallet');
  
  Route::get('/profile', function () {
    return view('account-pages.profile');
  })->name('profile');

  Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

  Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile');

  Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update');

  Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management');
});

Route::middleware('guest')->group(function () {
  Route::get('/signin', function () {
    return view('account-pages.signin');
  })->name('signin');
  
  Route::get('/signup', function () {
    return view('account-pages.signup');
  })->name('signup');
  
  Route::get('/sign-up', [RegisterController::class, 'create'])->name('sign-up');
  
  Route::post('/sign-up', [RegisterController::class, 'store']);
  
  Route::get('/sign-in', [LoginController::class, 'create'])->name('sign-in');

  Route::post('/sign-in', [LoginController::class, 'store']);

  Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');

  Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

  Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');

  Route::post('/reset-password', [ResetPasswordController::class, 'store']);
});