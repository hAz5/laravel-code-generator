<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class InterfaceGenerator extends CodeGenerator
{
    public string $model;
    public string $modelTableName;

    public function modelInterface($columns)
    {
        $model = $this->model;
        $modelTableName = $this->modelTableName ?? (string)Str::of($model)->snake()->plural();
        $columnsInterface = [];
        foreach ($columns as $column) {
            $columnsInterface[] = 'Has' . Str::studly($column['fieldName']) . 'Interface';
        }

        $variables = [
            '{{ model }}' => Str::studly($model),
            '{{ modelTableName }}' => $modelTableName,
            '{{ columnInterfaces }}' => implode(', ', $columnsInterface),
        ];

        $stubPath = __DIR__ . '/../Stubs/ModelInterface.stub';
        $outputPath = app_path() .  '/../storage/Model/' . Str::studly($model) . 'Interface.php';
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
        $outputPath = app_path() .  '/../storage/Interfaces/Has' . Str::studly($columnName) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function boolean()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnInterfaces/BooleanInterface.stub';
        $outputPath = app_path() .  '/../storage/Interfaces/Has' . Str::studly($columnName) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function float()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),
        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnInterfaces/FloatInterface.stub';
        $outputPath = app_path() .  '/../storage/Interfaces/Has' . Str::studly($columnName) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function integer()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),
        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnInterfaces/IntegerInterface.stub';
        $outputPath = app_path() .  '/../storage/Interfaces/Has' . Str::studly($columnName) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function string()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),
        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnInterfaces/StringInterface.stub';
        $outputPath = app_path() .  '/../storage/Interfaces/Has' . Str::studly($columnName) . 'Interface.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function date()
    {
        $colName = $this->columnName;
        $col = [
            'name' => $colName,
            'const' => Str::of($colName)->snake()->upper(),
            'studly' => Str::of($colName)->studly()
        ];
        $generated = view('CG::samples.columns.DateInterface', [
            'col' => $col
        ])->render();

        file_put_contents(app_path() .  '/../storage/Interfaces/Has' . Str::studly($colName) . 'Interface.php', $generated);
    }
}
