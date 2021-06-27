<?php

namespace GC\Generators;

abstract class CodeGenerator implements CodeGeneratorInterface
{
    /** @var string $columnName */
    protected string $columnName;

    /** @var string $mode */
    protected string $mode;

    /**
     * TraitGenerator constructor.
     * @param string $columnName
     */

    /**
     * TraitGenerator constructor.
     * @param string $columnName Column Name.
     * @param string $mode       Mode.
     */
    public function __construct(string $columnName, string $mode = self::MODE_STRING)
    {
        $this->columnName = $columnName;
        $this->mode = $mode;
    }

    /**
     * @param array  $variables  Variables.
     * @param string $stubPath   Stubpath.
     * @param string $outputPath Outputpath.
     * @return void
     */
    public function parser(array $variables, string $stubPath, string $outputPath)
    {
        $file = file_get_contents($stubPath);
        $file = str_replace(array_keys($variables), array_values($variables), $file);

        file_put_contents($outputPath, $file);
    }
}
