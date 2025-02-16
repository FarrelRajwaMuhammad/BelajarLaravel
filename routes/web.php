<?php

use App\Http\Controllers\dataHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/region', function () {
    $url = 'https://raw.githubusercontent.com/mtegarsantosa/json-nama-daerah-indonesia/refs/heads/master/regions.json';
    $response = Http::get($url);

    return response()->json($response->json());
});


Route::post('/region', [dataHandler::class, 'importFromJSON']);
