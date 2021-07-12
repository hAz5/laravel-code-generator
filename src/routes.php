<?php

use CG\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

$columns = [
    [
        'fieldName' => 'is_default',
        'type' => 'boolean',
        'enum' => false,
        'nullable' => true,
        'isTranslate' => false,
    ],
    [
        'fieldName' => 'gln_number',
        'type' => 'integer',
        'enum' => false,
        'nullable' => true,
        'isTranslate' => false,
    ],
    [
        'fieldName' => 'country_id',
        'type' => 'foreign',
        'enum' => false,
        'nullable' => true,
        'isTranslate' => false,
    ],
    [
        'fieldName' => 'price',
        'type' => 'float',
        'enum' => false,
        'nullable' => false,
        'isTranslate' => false,
    ],
    [
        'fieldName' => 'last_name',
        'type' => 'string',
        'enum' => true,
        'nullable' => false,
        'isTranslate' => true,
    ],
];
Route::get('/masoud', function () use ($columns) {
    $model = 'productDimension';

//    dd(Str::of('sale_system_id')->beforeLast('_id')->camel()); // for foreign)
//    dd(Str::of($model)->snake()->plural()->replace('_', '-'));
//
//    return;
    (new \CG\Generators\TestGenerator('', ''))->create($model, $columns);

//    (new \CG\Generators\RepositoryGenerator('', ''))->create($models);
});
Route::get('/cg', [CodeGeneratorController::class, 'index']);
Route::post('/cg/generate', [CodeGeneratorController::class, 'generate']);
