<?php

namespace App\Services;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $safeParams = []; // Lớp con sẽ định nghĩa
    protected $columnMap = [];  // Lớp con sẽ định nghĩa
    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
        'gt' => '>',
        'lt' => '<',
        'lte' => '<=',
        'gte' => '>=',
    ];

    public function transform(Request $request)
    {
        $query = $request->query();
        $wheres = [];

        foreach ($query as $param => $value) {
            if (isset($this->safeParams[$param])) {
                $column = $this->columnMap[$param] ?? $param;

                foreach ($value as $operator => $queryValue) {
                    if (in_array($operator, $this->safeParams[$param]) && isset($this->operatorMap[$operator])) {
                        $wheres[] = [
                            $column,
                            $this->operatorMap[$operator],
                            $queryValue,
                        ];
                    }
                }
            }
        }

        return $wheres;
    }
}
