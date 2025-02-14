<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

/**
 * @package    KodeKopi
 * @license    https://kodekopi.net/
 * @author     Tajillah
 *
 * DataTableService
 *
 * A service to streamline server-side processing for DataTables with Yajra.
 * Supports dynamic querying, joining, selecting columns, 
 * and generating JSON for DataTables frontend integration.
 */
class DataTableService
{
    protected $query;
    protected $dataTable;
    protected $showQueries = false; // Flag to control whether to include query logs in the response.
    protected $rawColumns = []; // Tambahkan properti untuk raw columns

    /**
     * Initialize the DataTableService with a specified table.
     *
     * @param string $table - The database table to query.
     */
    public function __construct($table)
    {
        $this->query = DB::table($table);
        $this->dataTable = DataTables::of($this->query);
    }

    /**
     * Static method to instantiate the service for a given table.
     *
     * @param string $table - The name of the table to query.
     * @return self
     */
    public static function draw($table)
    {
        return new self($table);
    }

    /**
     * Define specific columns to be selected.
     *
     * @param array $columns - Array of column names to include in the output. Defaults to all columns.
     * @return self
     */
    public function select($columns = ['*'])
    {
        $this->query->select($columns);
        return $this;
    }

    /**
     * Add where conditions to the query.
     *
     * Supported Operators:
     * - '=', '<>', '>', '<', '>=', '<='
     * - 'IS', 'IS NOT', 'IN', 'NOT IN'
     * - 'LIKE', 'NOT LIKE'
     * - 'BETWEEN', 'NOT BETWEEN'
     *
     * @param mixed $column
     * @param mixed $operator
     * @param mixed $value
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $callback = null)
    {
        if ($callback instanceof \Closure) {
            $this->query->when(true, function ($query) use ($callback) {
                $callback($query);
            });
        } elseif (is_array($value)) {
            switch (strtoupper($operator)) {
                case 'IN':
                    $this->query->whereIn($column, $value);
                    break;
                case 'NOT IN':
                    $this->query->whereNotIn($column, $value);
                    break;
                case 'BETWEEN':
                    $this->query->whereBetween($column, $value);
                    break;
                case 'NOT BETWEEN':
                    $this->query->whereNotBetween($column, $value);
                    break;
                default:
                    throw new \InvalidArgumentException("Invalid operator for array values");
            }
        } else {
            if ($operator === 'IS') {
                $this->query->whereNull($column);
            } elseif ($operator === 'IS NOT') {
                $this->query->whereNotNull($column);
            } elseif (in_array(strtoupper($operator), ['LIKE', 'NOT LIKE'])) {
                $this->query->where($column, $operator, $value);
            } else {
                $this->query->where($column, $operator, $value);
            }
        }

        return $this;
    }

    /**
     * Join another table with specified conditions.
     *
     * Supported Operators:
     * - '=', '<>', '>', '<', '>=', '<='
     * - 'IS', 'IS NOT', 'IN', 'NOT IN'
     * - 'LIKE', 'NOT LIKE'
     * - 'BETWEEN', 'NOT BETWEEN'
     *
     * @param string $table - Table to join.
     * @param array $conditions - Array of join conditions, each as an array:
     *                            [first_column, operator, second_column/value]
     * @param string $type - Type of join ('inner', 'left', 'right')
     * @return self
     */
    public function join($table, array $conditions, $type = 'inner')
    {
        $this->query->join($table, function ($join) use ($conditions) {
            foreach ($conditions as $condition) {
                if (is_array($condition)) {
                    [$first, $operator, $second] = $condition;

                    switch (strtoupper($operator)) {
                        case 'IS':
                            $join->whereNull($first);
                            break;
                        case 'IS NOT':
                            $join->whereNotNull($first);
                            break;
                        case 'IN':
                            $join->whereIn($first, (array) $second);
                            break;
                        case 'NOT IN':
                            $join->whereNotIn($first, (array) $second);
                            break;
                        case 'LIKE':
                            $join->where($first, 'LIKE', $second);
                            break;
                        case 'NOT LIKE':
                            $join->where($first, 'NOT LIKE', $second);
                            break;
                        case 'BETWEEN':
                            $join->whereBetween($first, (array) $second);
                            break;
                        case 'NOT BETWEEN':
                            $join->whereNotBetween($first, (array) $second);
                            break;
                        default:
                            $join->on($first, $operator, $second);
                            break;
                    }
                }
            }
        }, null, null, $type);

        return $this;
    }

    /**
     * Add a custom column to the DataTable with a callback function.
     *
     * @param string $name - The name of the new column.
     * @param callable $callback - A function to define the column's content.
     * @return self
     */
    public function addColumn($name, $callback)
    {
        $this->dataTable->addColumn($name, $callback);
        return $this;
    }

    /**
     * Toggle the inclusion of queries in the JSON response.
     *
     * @param bool $show - Set to true to include query logs, false to hide them.
     * @return self
     */
    public function showQueries($show = true)
    {
        $this->showQueries = $show;
        return $this;
    }

    /**
     * Tambahkan kolom yang akan dirender sebagai HTML mentah.
     *
     * @param array $columns
     * @return self
     */
    public function rawColumns(array $columns)
    {
        $this->rawColumns = $columns;
        $this->dataTable->rawColumns($columns); // Panggil metode bawaan Yajra
        return $this;
    }

    /**
     * Convert the DataTable query results to JSON format.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJson()
    {
        $result = $this->dataTable->toArray();

        if (!$this->showQueries) {
            unset($result['queries']); // Remove queries if not needed
        }

        return response()->json($result);
    }
}
