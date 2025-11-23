<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('/games/audiovisual', function () {
    return view('games.audio');
});
Route::get('/games/susunkata', function () {
    return view('games.susun');
});
Route::get('/games/pilihkata', function () {
    return view('games.pilih');
});
Route::get('/games/ran', function () {
    return view('games.rapid');
});

// Dongeng Routes
Route::get('/dongeng', function () {
    return view('dongeng.index');
})->name('dongeng.index');

Route::get('/dongeng/kelinci-kura-kura', function () {
    return view('dongeng.kelinci-kura-kura');
})->name('dongeng.kelinci-kura-kura');

Route::get('/dongeng/semut-belalang', function () {
    return view('dongeng.semut-belalang');
})->name('dongeng.semut-belalang');

Route::get('/dongeng/kancil-buaya', function () {
    return view('dongeng.kancil-buaya');
})->name('dongeng.kancil-buaya');

