<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class TestGenerator extends CodeGenerator
{
    public function __construct(string $columnName, string $mode = self::COLUMN_STRING)
    {
        parent::__construct(null, null);
    }

    /**
     * @param string $model
     * @param array $columns
     */
    public function create(string $model, array $columns): void
    {
        $variables = [
            '{{studlyModelName}}' => Str::studly($model),
            '{{pluralStudlyModelName}}' => Str::of($model)->studly()->plural(),
            '{{modelRouteName}}' => Str::of($model)->snake()->plural()->replace('_', '-'),
            '{{camelModelName}}' => Str::of($model)->camel(),
            '{{snakeModelName}}' => Str::of($model)->snake(),
            '{{snackUpperModelName}}' => Str::of($model)->snake()->upper(),
        ];
        $file = file_get_contents(__DIR__ . '/Stubs/Test.php');

        $file = str_replace(array_keys($variables), array_values($variables), $file);

        file_put_contents(app_path() . '/../storage/tests/' . Str::studly($model) . 'Test.php', $file);

    }
}
