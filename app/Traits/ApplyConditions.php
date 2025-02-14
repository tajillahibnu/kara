<?php
// app/Traits/ApplyConditions.php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApplyConditions
{
    /**
     * Apply a condition to the query.
     *
     * @param Builder $query
     * @param array $condition
     * @return void
     */
    public function applyCondition(Builder $query, array $condition)
    {
        // Ambil field, operator, dan nilai dari kondisi
        $column = $condition[0];
        $operator = isset($condition[1]) ? strtoupper($condition[1]) : '=';
        $value = isset($condition[2]) ? $condition[2] : null;
        $endValue = isset($condition[3]) ? $condition[3] : null;

        // Penanganan untuk kondisi yang menggunakan array atau nilai tunggal
        if (is_array($value)) {
            switch ($operator) {
                case 'IN':
                    $query->whereIn($column, $value);
                    break;

                case 'NOT IN':
                    $query->whereNotIn($column, $value);
                    break;

                case 'BETWEEN':
                    if ($endValue !== null) {
                        $query->whereBetween($column, [$value, $endValue]);
                    }
                    break;

                case 'NOT BETWEEN':
                    if ($endValue !== null) {
                        $query->whereNotBetween($column, [$value, $endValue]);
                    }
                    break;

                default:
                    throw new \InvalidArgumentException("Invalid operator for array values");
            }
        } else {
            switch ($operator) {
                case 'IS':
                    $query->whereNull($column);
                    break;

                case 'IS NOT':
                    $query->whereNotNull($column);
                    break;

                case 'LIKE':
                case 'NOT LIKE':
                    $query->where($column, $operator, $value);
                    break;

                default:
                    $query->where($column, $operator, $value);
                    break;
            }
        }
    }
}
