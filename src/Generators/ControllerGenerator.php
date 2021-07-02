<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class ControllerGenerator extends CodeGenerator
{
    /** @var boolean $isSimpleController */
    public bool $isSimpleController = true;

    /**
     * generate Conroller
     * @param string $model Model Name.
     * @return void
     */
    public function create(string $model): void
    {
        if ($this->isSimpleController) {
            $sample = 'CG::samples.SimpleController';
        } else {
            $sample = 'CG::samples.RepoController';
        }
        $generated = view($sample, [
            'model' => $model
        ])->render();

        $directoryPath = app_path() . '/../storage/Controller';

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        file_put_contents($directoryPath . '/' . Str::studly($model) . 'Controller.php', $generated);
    }
}
