<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class RequestGenerator extends CodeGenerator
{
    public function create(string $model, array $columns): void
    {
        foreach ($columns as $key => $column) {
            $columns[$key]['const'] = Str::of($column['fieldName'])->snake()->upper();
            $columns[$key]['studly'] = Str::studly($column['fieldName']);
            $columns[$key]['camel'] = Str::of($column['fieldName'])->beforeLast('_id')->camel(); // for foreign
            $columns[$key]['model'] = Str::of($column['fieldName'])->beforeLast('_id')->studly(); // for foreign
        }
        $generated = view('CG::samples.ModelRequest', [
            'columns' => $columns,
            'model' => $model,
            'studlyModelName' => Str::studly($model),
            'snackUpperModelName' => Str::of($model)->snake()->upper(),
            'snakeModelName' => Str::of($model)->snake()->singular(), // route binding name
        ])->render();

        if (!is_dir(app_path() . '/../storage/Requests')) {
            mkdir(app_path() . '/../storage/Requests', 0777, true);
        }

        file_put_contents(app_path() . '/../storage/Requests/' . Str::studly($model) . 'Request.php', $generated);
    }
}
