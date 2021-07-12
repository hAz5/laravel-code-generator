<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class MigrationGenerator extends CodeGenerator
{

    public function getValue($type)
    {
        switch ($type) {
            case self::COLUMN_INTEGER:
            case self::COLUMN_FOREIGN:
            case self::COLUMN_FLOAT:
                return 1;
            case self::COLUMN_STRING:
                return 'test';
            case self::COLUMN_BOOLEAN:
                return rand(0, 1);
        }
    }

    public function create(string $model, array $columns): void
    {
        $generated = view('CG::samples.ModelMigration', [
            'columns' => $columns,
            'model' => $model
        ])->render();

        if (!is_dir(app_path() . '/../storage/Migrations')) {
            mkdir(app_path() . '/../storage/Migrations', 0777, true);
        }

        file_put_contents(app_path() . '/../storage/Migrations/' . Str::studly($model) . 'Migration.php', $generated);
    }
}
