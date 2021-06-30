<?php

namespace CG\Controllers;

use CG\Generators\ColumnTraitGenerator;
use CG\Generators\FilterGenerator;
use CG\Generators\InterfaceGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class CodeGeneratorController
 * @package CG\Controllers
 */
class CodeGeneratorController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function index()
    {
        return view('CG::index');
    }

    /**
     * generate files
     * @param \Illuminate\Http\Request $request
     */
    public function generate(Request $request)
    {
       $model = $request->get('model');
       $columns = $request->get('columns');

       // generate model filter
        (new FilterGenerator('',''))->model($model['name'], $columns);

        // columns
       foreach ($columns as $column){
           (new InterfaceGenerator($column['fieldName'], $column['type']))->generate();
           (new ColumnTraitGenerator($column['fieldName'], $column['type']))->generate();
           (new FilterGenerator($column['fieldName'], $column['type']))->generate();
       }

       return response($columns, 400);
        //generate migration

        // gnerate model and model interface

    }

}
