<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class RequestGenerator extends CodeGenerator
{
    public function create(string $model, array $columns): void
    {
        $generated = view('CG::samples.ModelRequest', [
            'columns' => $columns,
            'model' => $model
        ])->render();

        if (!is_dir(app_path() . '/../storage/Requests')) {
            mkdir(app_path() . '/../storage/Requests', 0777, true);
        }

        file_put_contents(app_path() . '/../storage/Requests/' . Str::studly($model) . 'Request.php', $generated);
    }
}
