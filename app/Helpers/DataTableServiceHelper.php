<?php
use App\Services\DataTableService;
use Illuminate\Support\Facades\DB;

/**
 * Tambahkan whereNull sebagai metode tambahan.
 */
if (!method_exists(DataTableService::class, 'whereNull')) {
    DataTableService::macro('whereNull', function ($column) {
        return $this->where($column, 'IS');
    });
}

/**
 * Tambahkan whereNotNull sebagai metode tambahan.
 */
if (!method_exists(DataTableService::class, 'whereNotNull')) {
    DataTableService::macro('whereNotNull', function ($column) {
        return $this->where($column, 'IS NOT');
    });
}

/**
 * Tambahkan whereIn
 */
if (!method_exists(DataTableService::class, 'whereIn')) {
    DataTableService::macro('whereIn', function ($column, $values) {
        return $this->where($column, 'IN', $values);
    });
}

/**
 * Tambahkan whereNotIn
 */
if (!method_exists(DataTableService::class, 'whereNotIn')) {
    DataTableService::macro('whereNotIn', function ($column, $values) {
        return $this->where($column, 'NOT IN', $values);
    });
}

/**
 * Tambahkan whereBetween
 */
if (!method_exists(DataTableService::class, 'whereBetween')) {
    DataTableService::macro('whereBetween', function ($column, $values) {
        return $this->where($column, 'BETWEEN', $values);
    });
}

/**
 * Tambahkan whereNotBetween
 */
if (!method_exists(DataTableService::class, 'whereNotBetween')) {
    DataTableService::macro('whereNotBetween', function ($column, $values) {
        return $this->where($column, 'NOT BETWEEN', $values);
    });
}

/**
 * Tambahkan groupBy
 */
if (!method_exists(DataTableService::class, 'groupBy')) {
    DataTableService::macro('groupBy', function ($column) {
        // Asumsikan kamu punya method internal groupBy di DataTableService
        return $this->builder->groupBy($column);
    });
}

/**
 * Tambahkan orderBy
 */
if (!method_exists(DataTableService::class, 'orderBy')) {
    DataTableService::macro('orderBy', function ($column, $direction = 'asc') {
        return $this->builder->orderBy($column, $direction);
    });
}

/**
 * Tambahkan join
 */
if (!method_exists(DataTableService::class, 'join')) {
    DataTableService::macro('join', function ($table, $first, $operator, $second, $type = 'inner') {
        $this->builder->join($table, $first, $operator, $second, $type);
        return $this;
    });
}

/**
 * Tambahkan having
 */
if (!method_exists(DataTableService::class, 'having')) {
    DataTableService::macro('having', function ($column, $operator = null, $value = null) {
        $this->builder->having($column, $operator, $value);
        return $this;
    });
}

/**
 * Tambahkan limit
 */
if (!method_exists(DataTableService::class, 'limit')) {
    DataTableService::macro('limit', function ($value) {
        $this->builder->limit($value);
        return $this;
    });
}


/**
 * Tambahkan orWhere
 */
if (!method_exists(DataTableService::class, 'orWhere')) {
    DataTableService::macro('orWhere', function ($column, $operator = null, $value = null) {
        $this->builder->orWhere($column, $operator, $value);
        return $this;
    });
}

/**
 * Tambahkan orWhereNull
 */
if (!method_exists(DataTableService::class, 'orWhereNull')) {
    DataTableService::macro('orWhereNull', function ($column) {
        $this->builder->orWhereNull($column);
        return $this;
    });
}

/**
 * Tambahkan orWhereNotNull
 */
if (!method_exists(DataTableService::class, 'orWhereNotNull')) {
    DataTableService::macro('orWhereNotNull', function ($column) {
        $this->builder->orWhereNotNull($column);
        return $this;
    });
}

/**
 * Tambahkan orWhereIn
 */
if (!method_exists(DataTableService::class, 'orWhereIn')) {
    DataTableService::macro('orWhereIn', function ($column, $values) {
        $this->builder->orWhereIn($column, $values);
        return $this;
    });
}

/**
 * Tambahkan orWhereNotIn
 */
if (!method_exists(DataTableService::class, 'orWhereNotIn')) {
    DataTableService::macro('orWhereNotIn', function ($column, $values) {
        $this->builder->orWhereNotIn($column, $values);
        return $this;
    });
}

/**
 * Tambahkan offset
 */
if (!method_exists(DataTableService::class, 'offset')) {
    DataTableService::macro('offset', function ($value) {
        $this->builder->offset($value);
        return $this;
    });
}

/**
 * Tambahkan raw
 */
if (!method_exists(DataTableService::class, 'raw')) {
    DataTableService::macro('raw', function ($expression) {
        return DB::raw($expression);
    });
}

/**
 * Tambahkan toSql
 */
if (!method_exists(DataTableService::class, 'toSql')) {
    DataTableService::macro('toSql', function () {
        return $this->builder->toSql();
    });
}

/**
 * Tambahkan getBindings
 */
if (!method_exists(DataTableService::class, 'getBindings')) {
    DataTableService::macro('getBindings', function () {
        return $this->builder->getBindings();
    });
}

/**
 * Tambahkan distinct
 */
if (!method_exists(DataTableService::class, 'distinct')) {
    DataTableService::macro('distinct', function () {
        $this->builder->distinct();
        return $this;
    });
}

/**
 * Tambahkan count
 */
if (!method_exists(DataTableService::class, 'count')) {
    DataTableService::macro('count', function () {
        return $this->builder->count();
    });
}

/**
 * Tambahkan exists
 */
if (!method_exists(DataTableService::class, 'exists')) {
    DataTableService::macro('exists', function () {
        return $this->builder->exists();
    });
}

if (!method_exists(DataTableService::class, 'select')) {
    DataTableService::macro('select', function (...$columns) {
        $this->builder->select(...$columns);
        return $this;
    });
}
