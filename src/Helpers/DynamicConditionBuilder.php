<?php

namespace Mzm\PhpSso\Helpers;

class DynamicConditionBuilder
{
    /**
     * Build SQL WHERE clause and execute params dynamically.
     *
     * @param array $fields Array of field => value
     * @return array ['where' => string, 'params' => array]
     */
    public static function build(array $fields, array $userData): array
    {
        $conditions = [];
        $params = [];

        foreach ($fields as $column => $value) {
            if (!is_null($value)) {
                $conditions[] = "{$column} = :{$column}";
                $params[$column] = $userData[$value] ?? $value;
            }
        }

        $where = !empty($conditions) ? implode(' AND ', $conditions) : '1=1';

        return [
            'where' => $where,
            'params' => $params,
        ];
    }
}
