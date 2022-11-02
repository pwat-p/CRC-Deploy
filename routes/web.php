<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
});

Route::middleware(['auth'])->group(function () {

    // Route create branch
    Route::get('create-branch', [\App\Http\Controllers\BranchController::class, 'create'])->name("branch");
    Route::post('store-branch', [\App\Http\Controllers\BranchController::class, 'store'])->name('branch.store');
    Route::post('edit-branch/{id}', [\App\Http\Controllers\BranchController::class, 'update'])->name('branch.update');
    Route::post('remove-branch/{id}', [\App\Http\Controllers\BranchController::class, 'destroy'])->name('branch.remove');

    // Route Color
    Route::post('create-color', [\App\Http\Controllers\ColorController::class, 'store'])->name('color.store');
    Route::post('edit-color/{id}', [\App\Http\Controllers\ColorController::class, 'update'])->name('color.update');
    Route::post('remove-color/{id}', [\App\Http\Controllers\ColorController::class, 'destroy'])->name('color.remove');

    // Route CarModel
    Route::post('create-model', [\App\Http\Controllers\CarModelController::class, 'store'])->name('model.store');
    Route::post('edit-model/{id}', [\App\Http\Controllers\CarModelController::class, 'update'])->name('model.update');
    Route::post('remove-model/{id}', [\App\Http\Controllers\CarModelController::class, 'destroy'])->name('model.remove');



    // Route register
    Route::get('branch-owner/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name("bo.register");
    Route::post('branch-owner/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('bo.register.create');

    // Route userlist
    Route::get('userlists', [\App\Http\Controllers\UserController::class, 'index'])->name('userlist');
    Route::post('userlists/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');

    // Route profile
    Route::get('profile', [\App\Http\Controllers\UserController::class, 'create'])->name('profile');
    Route::get('/change-password', function () {
        return view('user.repassword');
    })->name('repassword');
    Route::post('change-password', [\App\Http\Controllers\UserController::class, 'rePassword'])->name('repassword.re');

    // Route repair Order
    Route::resource('repairOrder', \App\Http\Controllers\RepairController::class);
    Route::put('repairList/update/{repairList}', [\App\Http\Controllers\RepairController::class, 'updateCheckList'])->name('repairOrder.updateCheckList');

    Route::put('repairList/timestamp/{id}', [\App\Http\Controllers\StatusPaymentController::class, 'timestampStatus'])->name('repairList.timestampStatus');
    Route::put('repairList/setPayPrice/{id}', [\App\Http\Controllers\StatusPaymentController::class, 'setPayPrice'])->name('repairList.setPayPrice');
});

Route::resource('line/repairInfo', \App\Http\Controllers\RepairInfoController::class);

Route::get('line/carRegistered', function () {
    return view('lineliff.carRegistered');
})->name('carRegistered.index');
Route::post('line/carRegistered/connect/', [\App\Http\Controllers\RepairInfoController::class, 'connect'])->name('carRegistered.connect');

Route::get('line/customer/register', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
Route::post('line/customer/register', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customer.register');
Route::get('line/customer/edit', [\App\Http\Controllers\CustomerController::class, 'editIndex'])->name('customer.edit');
Route::post('line/customer/edit', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');

require __DIR__ . '/auth.php';
