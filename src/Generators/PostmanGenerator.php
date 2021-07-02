<?php

namespace CG\Generators;

use Illuminate\Support\Str;

class PostmanGenerator extends CodeGenerator
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

    public function create(array $columns): array
    {
        $queryString = '';
        $fields = [];

        foreach ($columns as $column) {
            // create queryString
            $value = $this->getValue($column['type']);
            $queryString .= Str::camel($column['fieldName']) . '=' . $value . '&';
            // create store and update request body
            $fields[$column['fieldName']] = $value;
        }

       return [
           'queryString' => $queryString,
           'fields' => $fields
       ];
    }
}
