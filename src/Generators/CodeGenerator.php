<?php

namespace CG\Generators;

use Illuminate\Support\Str;
use function PHPUnit\Framework\directoryExists;

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
     * @return void
     */
    public function generate()
    {
        $method = Str::camel($this->mode);
        if (method_exists($this, $method)) {
            $this->$method();
        }
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

        if (!is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath));
        }
        file_put_contents($outputPath, $file);
    }

    /**
     * get const of column.
     *
     * @param string $columnName Column Name.
     * @return string
     */
    public function getColumnConstName(string $columnName): string
    {
        return Str::upper($columnName);
    }
}
