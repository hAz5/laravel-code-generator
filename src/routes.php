<?php

use CG\Controllers\CodeGeneratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/masoud', function (){
    $model = 'subdomain';
    $variables = [
        '{{studlyModelName}}' => Str::studly($model),
        '{{pluralStudlyModelName}}' => Str::of($model)->studly()->plural(),
        '{{modelRouteName}}' => Str::of($model)->snake()->plural()->replace('_', '-'),
        '{{camelModelName}}' => Str::of($model)->camel(),
        '{{snakeModelName}}' => Str::of($model)->snake(),
        '{{snackUpperModelName}}' => Str::of($model)->snake()->upper(),
    ];
    $file = file_get_contents(__DIR__ . '/Stubs/Test.php');

    $file = str_replace(array_keys($variables), array_values($variables), $file);

    file_put_contents(app_path() .  '/../storage/abas/' . Str::studly($model) . 'Test.php', $file);
    return view('index');
});
Route::get('/cg', [CodeGeneratorController::class, 'index']);
Route::post('/cg/generate', [CodeGeneratorController::class, 'generate']);
