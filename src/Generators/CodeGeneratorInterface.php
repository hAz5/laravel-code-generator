<?php

namespace CG\Generators;

/**
 * Interface CodeGeneratorInterface
 */
interface CodeGeneratorInterface
{
    const COLUMN_STRING = 'string';
    const COLUMN_INTEGER = 'integer';
    const COLUMN_FLOAT = 'float';
    const COLUMN_BOOLEAN = 'boolean';
    const COLUMN_DATE = 'date';
    const COLUMN_EUM = 'enum';
    const COLUMN_FOREIGN = 'foreign';

    /**
     * @return void
     */
    public function generate();
}
