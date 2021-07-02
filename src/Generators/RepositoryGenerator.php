<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class RepositoryGenerator extends CodeGenerator
{
    /** @var boolean $isSimpleController */
    public bool $hasTranslation = false;

    /**
     * generate Conroller
     * @param string $model Model Name.
     * @return void
     */
    public function create(string $model): void
    {
        $sample = 'CG::samples.TranslationRepository';

        $generated = view($sample, [
            'model' => $model
        ])->render();

        $directoryPath = app_path() . '/../storage/Repository';

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
        file_put_contents($directoryPath . '/' . Str::studly($model) . 'Repository.php', $generated);
    }
}
