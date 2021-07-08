<?php

namespace CG\Generators;

use Illuminate\Support\Str;

/**
 * Class ModelGenerator
 *
 * @package CG\Generators
 */
class ModelGenerator extends CodeGenerator
{
    public function __construct()
    {

    }

    /**
     * @param $model
     * @param $columns
     */
    public function model($model, $columns)
    {
        $columnsTrait = [];
        $columnNames = [];
        $attributes = [];
        foreach ($columns as $column) {
            if($column['isTranslate']){
                continue;
            }
            $columnName = Str::of($column['fieldName'])->camel();
            $columnsTrait [] = 'use Has' . Str::studly($column['fieldName']) . 'Trait;';
            $columnNames[] = 'self::' . Str::of($columnName)->snake()->upper();
        }

        $variables = [
            '{{ model }}' => (string) Str::of($model)->studly(),
            '{{ modelFilter }}' => (string) Str::of($model)->studly() . 'Filter',
            '{{ modelInterface }}' => (string) Str::of($model)->studly() . 'Interface',
            '{{ columnsTrait }}' => implode("\n    ", $columnsTrait),
            '{{ columns }}' => implode(",\n        ", $columnNames),
        ];

        $stubPath = __DIR__ . '/../Stubs/Model.stub';
        $outputPath = app_path() . '/../storage/Model/' . Str::studly($model) . '.php';
        $this->parser($variables, $stubPath, $outputPath);
    }
}
