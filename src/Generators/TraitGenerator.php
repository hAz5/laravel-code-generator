<?php
namespace GC\Generators;

use Illuminate\Support\Str;

class TraitGenerator extends CodeGenerator
{
    /**
     * @return void
     */
    public function generate()
    {
        $method = $this->mode;
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    /**
     * @return void
     */
    private function foreign()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ model }}' => Str::studly(Str::beforeLast($columnName, '_id')),
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => Str::camel($columnName),
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelName }}' => Str::studly(Str::beforeLast($columnName, '_id')),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
        ];

        $file = file_get_contents(app_path('Stubs/ColumnTraits/ForeignIdTrait.stub'));

        $file = str_replace(array_keys($variables), array_values($variables), $file);

        file_put_contents(app_path() .  '/../storage/abas/Has' . Str::studly($columnName) . 'Trait.php', $file);
    }

    /**
     * @return void
     */
    private function string()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => Str::camel($columnName),
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ columnUpperCase }}' => ucwords(str_replace('_', ' ', $columnName)),
        ];

        $stubPath = app_path('Stubs/ColumnTraits/StringTrait.stub');
        $outputPath = app_path() .  '/../storage/abas/Has' . Str::studly($columnName) . 'Trait.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    private function integer()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => Str::camel($columnName),
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ columnUpperCase }}' => ucwords(str_replace('_', ' ', $columnName)),
        ];

        $stubPath = app_path('Stubs/ColumnTraits/IntegerTrait.stub');
        $outputPath = app_path() .  '/../storage/abas/Has' . Str::studly($columnName) . 'Trait.php';
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    private function float()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => Str::camel($columnName),
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ columnUpperCase }}' => ucwords(str_replace('_', ' ', $columnName)),
        ];

        $stubPath = app_path('Stubs/ColumnTraits/FloatTrait.stub');
        $outputPath = app_path() .  '/../storage/abas/Has' . Str::studly($columnName) . 'Trait.php';
        $this->parser($variables, $stubPath, $outputPath);
    }
}
