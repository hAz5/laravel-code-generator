<?php

use CG\Generators\CodeGeneratorInterface;
use CG\Generators\InterfaceGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/cg', function () {
    $generator = new InterfaceGenerator(CodeGeneratorInterface::MODE_MODEL_INTERFACE);
    $generator->model = 'User';
//    $generator->model = 'User';
    $generator->generate();
});
