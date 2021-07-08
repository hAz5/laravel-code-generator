<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class TestGenerator extends CodeGenerator
{

    public function getBadValue($type)
    {
        switch ($type) {
            case self::COLUMN_FOREIGN:
            case self::COLUMN_INTEGER:
            case self::COLUMN_BOOLEAN:
            case self::COLUMN_FLOAT:
            case self::COLUMN_DATE:
            case self::COLUMN_EUM:
                return '\'a\'';
            case self::COLUMN_STRING:
                return 9999999;
        }
    }

    /**
     * @param string $model
     * @param array $columns
     */
    public function create(string $model, array $columns): void
    {
        foreach ($columns as $key => $column) {
            $columns[$key]['const'] = Str::of($column['fieldName'])->snake()->upper();
            $columns[$key]['studly'] = Str::studly($column['fieldName']);
            $columns[$key]['camel'] = Str::of($column['fieldName'])->beforeLast('_id')->camel(); // for foreign
            $columns[$key]['model'] = Str::of($column['fieldName'])->beforeLast('_id')->studly(); // for foreign
            $columns[$key]['badValue'] = $this->getBadValue($column['type']);
        }
        $generated = view(
            'CG::samples.ModelTest',
            [
                'model' => $model,
                'columns' => $columns,
                'studlyModelName' => Str::studly($model),
                'pluralStudlyModelName' => Str::of($model)->plural()->studly(),
                'pluralStudlyUpperModelName' => Str::of($model)->studly()->plural()->snake()->upper(),//permission
                'studlyUpperModelName' => Str::of($model)->studly()->snake()->upper(),//permission
                'modelRouteName' => Str::of($model)->snake()->plural()->replace('_', '-'),
                'camelModelName' => Str::of($model)->camel(),
                'snakeModelName' => Str::of($model)->snake()->singular(), // route binding name
                'snackUpperModelName' => Str::of($model)->snake()->upper(),
            ]
        )->render();

        $directoryPath = app_path() . '/../storage/Test';

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        file_put_contents($directoryPath . '/' . Str::studly($model) . 'Test.php', $generated);
    }
}
