<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\testNoty;
use App\Models\User;
use App\Jobs\UserQueueJob;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    $user = new User();
    $user ->notify(new testNoty());
    return "!234";
});

Route::get("/queue", function (){
    $users = User::where('login_at', '<=',now()->subDay(7))->get();
    \Illuminate\Support\Facades\Log::info("QUEUE IS START!!");
    foreach ($users as $user)
        UserQueueJob::dispatch($user);
    \Illuminate\Support\Facades\Log::info("QUEUE IS END!!");
    return $user;
});
