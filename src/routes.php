<?php

use CG\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/masoud', function () {
    $models = 'address';
    $columns = [
        [
            'fieldName' => 'is_default',
            'type' => 'integer'
        ],
        [
            'fieldName' => 'gln_number',
            'type' => 'integer'
        ],
        [
            'fieldName' => 'country_id',
            'type' => 'foreign'
        ],
    ];
    (new \CG\Generators\ResourceGenerator('', ''))->create($models, $columns);
});
Route::get('/cg', [CodeGeneratorController::class, 'index']);
Route::post('/cg/generate', [CodeGeneratorController::class, 'generate']);
