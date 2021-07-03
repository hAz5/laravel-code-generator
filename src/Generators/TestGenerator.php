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
                return 'test';
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
            $columns[$key]['badValue'] = $this->getBadValue($column['type']);
        }
        $generated = view(
            'CG::samples.Test',
            [
                'model' => $model,
                'columns' => $columns,
                'studlyModelName' => Str::studly($model),
                'pluralStudlyUpperModelName' => Str::of($model)->studly()->plural()->upper(),//permission
                'studlyUpperModelName' => Str::of($model)->studly()->upper(),//permission
                'modelRouteName' => Str::of($model)->snake()->plural()->replace('_', '-'),
                'camelModelName' => Str::of($model)->camel(),
                'snakeModelName' => Str::of($model)->snake(),
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
