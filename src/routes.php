<?php

use CG\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/masoud', function (){
    $models = 'address';
    $columns = [
      [
          'fieldName' => 'is_default'
      ],
        [
            'fieldName' => 'gln_number'
        ]
    ];
    (new \CG\Generators\ResourceGenerator('',''))->create($models, $columns);
    return view('index');
});
Route::get('/cg', [CodeGeneratorController::class, 'index']);
Route::post('/cg/generate', [CodeGeneratorController::class, 'generate']);
