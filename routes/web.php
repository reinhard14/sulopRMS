<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Models\Department;

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

//routes for php artisan ui bootstrap --auth
Auth::routes();

//Admin Dashboard Route
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
//Home Route
Route::get('/user/dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('user.dashboard');

//route resource
Route::resource('administrator', AdministratorController::class);
Route::resource('department', DepartmentController::class);
Route::resource('user', UserController::class);
Route::resource('admin/users', AdminUserController::class)->names([
    'index' => 'admin.users.index',
    'create' => 'admin.users.create',
    'destroy' => 'admin.users.destroy',
    'edit' => 'admin.users.edit',
    'show' => 'admin.users.show',
    'store' => 'admin.users.store',
    'update' => 'admin.users.update'
]);
Route::get('admin/users/{user}/form/{form}/answers', [App\Http\Controllers\AdminUserController::class, 'showAnswers'])->name('admin.users.show-answers');

//AdminUser routes
//users additional routes
Route::delete('admin/users', [App\Http\Controllers\AdminUserController::class, 'destroySelected'])->name('admin.user.deleteSelected');


//administrator additional routes
Route::delete('administrator/', [App\Http\Controllers\AdministratorController::class, 'destroySelected'])->name('administrator.deleteSelected');

//departments additional routes
Route::delete('department/', [App\Http\Controllers\DepartmentController::class, 'destroySelected'])->name('department.deleteSelected');

//forms routes
Route::post('forms', [App\Http\Controllers\FormController::class, 'store'])->name('form.store');
Route::put('forms/{form}', [App\Http\Controllers\FormController::class, 'update'])->name('form.update');
Route::delete('forms/{form}', [App\Http\Controllers\FormController::class,'destroy'])->name('form.destroy');

//input routes
Route::post('input', [App\Http\Controllers\InputController::class, 'store'])->name('input.store');
Route::delete('input/{input}', [App\Http\Controllers\InputController::class, 'destroy'])->name('input.destroy');

//answer routes
Route::post('/home/form/answer', [App\Http\Controllers\AnswerController::class, 'store'])->name('answer.store');

//users routes
Route::get('user/answers', [App\Http\Controllers\UserController::class, 'answersIndex'])->name('user.answers-index');
Route::get('user/{form}/answers', [App\Http\Controllers\UserController::class, 'answersShow'])->name('user.answers-show');
Route::delete('user/{form}/answers/{answers_submission}/delete', [App\Http\Controllers\UserController::class, 'destroyFormAnswers'])->name('user.answers-delete');
