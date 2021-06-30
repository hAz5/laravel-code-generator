<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class FilterGenerator extends CodeGenerator
{
    public string $model;
    public string $modelTableName;

    public function attributesType($type): string
    {
        switch ($type) {
            case 'integer' :
            case 'foreign':
                return 'int';
            case 'boolean' :
                return 'bool';
            case 'float' :
            case 'string' :
                return $type;
        }

    }

    public function model($model, $columns)
    {
        $filtersTrait = [];
        $filtersName = [];
        $attributes = [];
        foreach ($columns as $column) {
            $filter = Str::of($column['fieldName'])->camel();
            $filtersTrait [] = 'use Filter' . Str::studly($column['fieldName']) . 'Trait;';
            $filtersName [] = '\'' . $filter . '\'';
            $attributes [] = '\'' . $filter . '\' => \'' . $this->attributesType($column['type']) . '\'';
        }

        $variables = [
            '{{ columnStudyCase }}' => Str::of($model)->studly(),
            '{{ filtersTrait }}' => implode("\n    ", $filtersTrait),
            '{{ filtersNames }}' => implode(",\n        ", $filtersName),
            '{{ attributes }}' => implode(",\n        ", $attributes)
        ];


        $stubPath = __DIR__ . '/../Stubs/ModelFilter.stub';
        $outputPath = app_path() . '/../storage/Model/' . Str::studly($model) . 'Filter.php';
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
            '{{ columnCamel }}' => Str::camel($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnUpperCase }}' => Str::of($columnName)->snake(' ')->studly(),

        ];

        $stubPath = __DIR__ . '/../Stubs/ColumnFilters/FilterForeignTrait.stub';
        $outputPath = app_path() . '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
        $outputPath = app_path() . '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
        $outputPath = app_path() . '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
        $outputPath = app_path() . '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
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
        $outputPath = app_path() . '/../storage/Filters/Filter' . Str::studly($columnName) . 'Trait.php';
        $this->parser($variables, $stubPath, $outputPath);
    }
}
