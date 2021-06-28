<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class InterfaceGenerator extends CodeGenerator
{
    public string $model;
    public string $modelTableName;

    public function modelInterface()
    {
        $model = $this->model;
        $modelTableName = $this->modelTableName ?? (string)Str::of($model)->snake()->plural();
        $variables = [
            '{{ model }}' => Str::studly($model),
            '{{ modelTableName }}' => $modelTableName,
            '{{ columnInterfaces }}' => null,
        ];


        $stubPath = __DIR__ . '/../Stubs/ModelInterface.stub';
        $outputPath = app_path() .  '/../storage/abas/' . Str::studly($model) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function foreign()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnInterfaces/foreignIdInterface.stub';
        $outputPath = app_path() .  '/../storage/abas/Has' . Str::studly($columnName) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }
}
