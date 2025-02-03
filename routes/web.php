<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SupportAgentController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
     session()->forget('user');
    return view('frontpage');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::get('dashboard', [SupportAgentController::class, 'dashboard'])->name('dashboard');
    Route::get('UserView', [SupportAgentController::class, 'userView'])->name('user_view');
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

    
});

Route::get('onlinetickt', [CustomerController::class, 'userHome'])->name('frontpage');
Route::get('ticket_dashboard', [CustomerController::class, 'dashboard'])->name('customer.support_ticket_open');
Route::post('customer_store', [CustomerController::class, 'userStore']);
Route::post('customer_sts', [CustomerController::class, 'custmrsts']);
Route::post('reply_store', [SupportAgentController::class, 'replyStore']);


