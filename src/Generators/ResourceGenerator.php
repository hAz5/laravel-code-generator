<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class ResourceGenerator extends CodeGenerator
{
    public function create(string $model, array $columns): void
    {
        $generated = view('CG::samples.ModelResource', [
            'columns' => $columns,
            'model' => $model
        ])->render();

        if (!is_dir(app_path() . '/../storage/Resources')) {
            mkdir(app_path() . '/../storage/Resources', 0777, true);
        }

        file_put_contents(app_path() . '/../storage/Resources/' . Str::studly($model) . 'Resource.php', $generated);
    }
}
