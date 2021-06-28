<?php

use CG\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;

Route::get('/cg', [CodeGeneratorController::class, 'index']);
Route::post('/cg/generate', [CodeGeneratorController::class, 'generate']);
