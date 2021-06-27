<?php

namespace GC\Generators;

/**
 * Interface CodeGeneratorInterface
 */
interface CodeGeneratorInterface
{
    const MODE_STRING = 'string';
    const MODE_INTEGER = 'integer';
    const MODE_FLOAT = 'float';
    const MODE_BOOLEAN = 'boolean';
    const MODE_DATE = 'date';
    const MODE_EUM = 'enum';
    const MODE_FOREIGN = 'foreign';

    /**
     * @return void
     */
    public function generate();
}
