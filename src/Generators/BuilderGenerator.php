<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class BuilderGenerator extends CodeGenerator
{
    /**
     * @param string $model
     * @param array  $columns
     */
    public function create(string $model, array $columns, $bundle): void
    {
        foreach ($columns as $key => $column) {
            $columns[$key]['const'] = Str::of($column['fieldName'])->snake()->upper();
            $columns[$key]['studly'] = Str::studly($column['fieldName']);
            $columns[$key]['camel'] = Str::of($column['fieldName'])->beforeLast('_id')->camel(); // for foreign
            $columns[$key]['model'] = Str::of($column['fieldName'])->beforeLast('_id')->studly(); // for foreign
        }
        $generated = view(
            'CG::samples.Builder',
            [
                'bundle' => $bundle,
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

        $directoryPath = app_path() . '/../storage/Simple';

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        file_put_contents($directoryPath . '/' . Str::studly($model) . 'Builder.php', $generated);
    }
}
