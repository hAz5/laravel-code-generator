<?php

use CG\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
$columns = [
    [
        'fieldName' => 'is_default',
        'type' => 'boolean'
    ],
    [
        'fieldName' => 'gln_number',
        'type' => 'integer'
    ],
    [
        'fieldName' => 'country_id',
        'type' => 'foreign'
    ],
    [
        'fieldName' => 'price',
        'type' => 'float'
    ],
];
Route::get('/masoud', function () use ($columns){
    $models = 'SaleSystem';

    (new \CG\Generators\RepositoryGenerator('', ''))->create($models);
});
Route::get('/cg', [CodeGeneratorController::class, 'index']);
Route::post('/cg/generate', [CodeGeneratorController::class, 'generate']);
