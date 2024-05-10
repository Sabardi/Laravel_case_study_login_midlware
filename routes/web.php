<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;



Route::get('/login', [MahasiswaController::class,'login']);
Route::post('/login', [MahasiswaController::class,'prosesLogin']);
Route::get('/logout', [MahasiswaController::class,'logout']);

 Route::redirect('/', '/login');

 Route::get('/daftarMahasiswa', [MahasiswaController::class,'daftarMahasiswa'])->middleware('login');

 Route::get('/tabelMahasiswa', [MahasiswaController::class,'tabelMahasiswa'])->middleware('login');

 Route::get('/blogMahasiswa', [MahasiswaController::class,'blogMahasiswa'])->middleware('login');

