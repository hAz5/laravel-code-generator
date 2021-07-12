<?php

namespace CG\Controllers;

use CG\Generators\ColumnTraitGenerator;
use CG\Generators\FilterGenerator;
use CG\Generators\InterfaceGenerator;
use CG\Generators\ModelGenerator;
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
        (new FilterGenerator('', ''))->model($model['name'], $columns);
        foreach ($columns as $column) {
            if ($column['isTranslate']) {
                continue;
            }
            (new InterfaceGenerator($column['fieldName'], $column['type']))->generate();
            (new ColumnTraitGenerator($column['fieldName'], $column['type']))->generate();
            (new FilterGenerator($column['fieldName'], $column['type']))->generate();
        }
        $interfaceGenerator = new InterfaceGenerator('', '');
        $interfaceGenerator->model = $model['name'];
        $interfaceGenerator->modelTableName = $model['table'];
        $interfaceGenerator->modelInterface($columns);

        (new ModelGenerator())->model($model['name'], $columns);
        (new \CG\Generators\RequestGenerator('', ''))->create($model['name'], $columns);
        (new \CG\Generators\ResourceGenerator('', ''))->create($model['name'], $columns);
        (new \CG\Generators\MigrationGenerator('', ''))->create($model['name'], $columns);
        $controllerGenerator = new \CG\Generators\ControllerGenerator('', '');
        $controllerGenerator->isSimpleController = !$model['hasTranslation'];
        $controllerGenerator->create($model['name']);
        (new \CG\Generators\RepositoryGenerator('', ''))->create($model['name']);
        (new \CG\Generators\TestGenerator('', ''))->create($model['name'], $columns);

        return response([
            'postman' =>  (new \CG\Generators\PostmanGenerator('', ''))->create($model['name'], $columns)
        ], 400);
    }
}
