<?php

namespace GC\Generators;

use Illuminate\Support\Str;

class InterfaceGenerator
{
    /** @var string  */
    private string $columnName;

    /**
     * TraitGenerator constructor.
     * @param string $columnName
     */

    /**
     * TraitGenerator constructor.
     * @param string $columnName Column Name.
     */
    public function __construct(string $columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * @return void
     */
    public function generate()
    {
        $columnName = $this->columnName;
        $variables = [
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => $columnName,
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => Str::upper($columnName),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
        ];

        $file = file_get_contents(__DIR__ . '/Stubs/ColumnInterfaces/foreignIdInterface.stub');

        $file = str_replace(array_keys($variables), array_values($variables), $file);

        file_put_contents(app_path() .  '/../storage/abas/Has' . Str::studly($columnName) . 'Interface.php', $file);
    }
}
