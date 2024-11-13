<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::get('success', function () {
    return response()->json(['message' => 'success!']);
});

Route::get('fail', function () {
    return response()->json(['message' => 'fail!'], 502);
});