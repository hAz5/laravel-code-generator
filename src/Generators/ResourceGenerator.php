<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class ResourceGenerator extends CodeGenerator
{
    public function create(string $model, array $columns): void
    {
        $fields = [];
        foreach ($columns as $column){
            $field = ((string)Str::of($model)->studly()).'::'. ((string)Str::of($column['fieldName'])->snake()->upper());
            $value =  '$this->get'.Str::studly($column['fieldName'])."(),";
            $fields [] = $field.' => '.$value;
        }

        $variables = [
            '{{studlyModelName}}' => Str::studly($model),
            '{{fields}}' => implode("\n              ", $fields),
        ];
        $file = file_get_contents(__DIR__ . '/../Stubs/ModelResource.php');

        $file = str_replace(array_keys($variables), array_values($variables), $file);

        file_put_contents(app_path() . '/../storage/Resources/' . Str::studly($model) . 'Resource.php', $file);

    }
}
