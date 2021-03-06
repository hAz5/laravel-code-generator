<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class ColumnTraitGenerator extends CodeGenerator
{

    /**
     * @return array
     */
    public function getVariables(): array
    {
        $columnName = $this->columnName;
        return [
            '{{ model }}' => Str::studly(Str::beforeLast($columnName, '_id')),
            '{{ columnStudyCase }}' => Str::studly($columnName),
            '{{ column }}' => Str::camel($columnName),
            '{{ columnPlural }}' => Str::camel(Str::plural($columnName)),
            '{{ columnConstName }}' => $this->getColumnConstName($columnName),
            '{{ modelName }}' => Str::studly(Str::beforeLast($columnName, '_id')),
            '{{ modelCamelcase }}' => Str::camel(Str::beforeLast($columnName, '_id')),
            '{{ columnCamelCase }}' => Str::camel($columnName),
            '{{ columnUpperCase }}' => (string) Str::of($columnName)->snake(' ')->studly(),
        ];
    }

    /**
     * @return void
     */
    public function foreign()
    {

        $variables = $this->getVariables();
        $stubPath = __DIR__ . '/../Stubs/ColumnTraits/ForeignIdTrait.stub';
        $outputPath = $this->getColumnTraitFullPath($this->columnName);
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function date()
    {
        $colName = $this->columnName;
        $col = [
            'name' => $colName,
            'const' => Str::of($colName)->snake()->upper(),
            'studly' => Str::of($colName)->studly()
        ];
        $generated = view('CG::samples.columns.Date', [
            'col' => $col
        ])->render();

        file_put_contents($this->getColumnTraitFullPath($colName), $generated);
    }

    /**
     * @return void
     */
    public function string()
    {
        $columnName = $this->columnName;
        $variables = $this->getVariables();

        $stubPath = __DIR__ . '/../Stubs/ColumnTraits/StringTrait.stub';
        $outputPath = $this->getColumnTraitFullPath($columnName);
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function integer()
    {
        $variables = $this->getVariables();

        $stubPath = __DIR__ . '/../Stubs/ColumnTraits/IntegerTrait.stub';
        $outputPath = $this->getColumnTraitFullPath($this->columnName);
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function float()
    {
        $variables = $this->getVariables();

        $stubPath = __DIR__ . '/../Stubs/ColumnTraits/FloatTrait.stub';
        $outputPath = $this->getColumnTraitFullPath($this->columnName);
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * @return void
     */
    public function boolean()
    {
        $variables = $this->getVariables();

        $stubPath = __DIR__ . '/../Stubs/ColumnTraits/BooleanTrait.stub';
        $outputPath = $this->getColumnTraitFullPath($this->columnName);
        $this->parser($variables, $stubPath, $outputPath);
    }

    /**
     * get path of column trait.
     *
     * @param string      $columnName Column Name.
     * @param string|null $directory  Directory that we want to add our trait.
     * @return string
     */
    public function getColumnTraitFullPath(string $columnName, ?string $directory = null): string
    {
        if (!empty($directory)) {
            mkdir($directory, 0777, true);
            $directory .= '/';
        }

        return app_path() . '/../storage/Traits/' . $directory . $this->getColumnTraitFileName($columnName) . '.php';
    }

    /**
     * get column trait file name and class name.
     *
     * @param string $columnName Column Name.
     * @return string
     */
    public function getColumnTraitFileName(string $columnName): string
    {
        return  'Has' . Str::studly($columnName) . 'Trait';
    }
}
