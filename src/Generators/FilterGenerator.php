<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class FilterGenerator extends CodeGenerator
{
    public string $model;
    public string $modelTableName;

//    public function modelInterface()
//    {
//        $model = $this->model;
//        $modelTableName = $this->modelTableName ?? (string)Str::of($model)->snake()->plural();
//        $variables = [
//            '{{ model }}' => Str::studly($model),
//            '{{ modelTableName }}' => $modelTableName,
//            '{{ columnInterfaces }}' => null,
//        ];
//
//
//        $stubPath = __DIR__ . '/../Stubs/ModelInterface.stub';
//        $outputPath = app_path() .  '/../storage/Model/' . Str::studly($model) . 'Interface.php';
//        $this->parser($variables, $stubPath, $outputPath);
//    }
//
    /**
     * @return void
     */
    public function foreign()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ columnCamel }}' => Str::camel($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),

        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnFilters/FilterForeignTrait.stub';
        $outputPath = app_path() .  '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
            '{{ columnCamel }}' => Str::camel($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),

        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnFilters/FilterBooleanTrait.stub';
        $outputPath = app_path() .  '/../storage/ColumnFilters/Filter' . Str::studly($columnName) . 'Trait.php';
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
            '{{ columnCamel }}' => Str::camel($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),

        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnFilters/FilterFloatTrait.stub';
        $outputPath = app_path() .  '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
            '{{ columnCamel }}' => Str::camel($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),

        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnFilters/FilterIntegerTrait.stub';
        $outputPath = app_path() .  '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
            '{{ columnCamel }}' => Str::camel($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),

        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnFilters/FilterStringTrait.stub';
        $outputPath = app_path() .  '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
        $this->parser($variables, $stubPath, $outputPath);
    }
}
