<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ApplyConditions;

abstract class BaseRepository
{
    use ApplyConditions;

    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model = null)
    {
        if (! $model instanceof Model) {
            throw new \InvalidArgumentException("The provided argument is not a valid model.");
        }

        $this->model = $model;
    }

    /**
     * Set model secara dinamis.
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this; // Mengembalikan instance untuk chaining
    }

    /**
     * Ambil semua data dengan kondisi tertentu
     *
     * @param array $conditions
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $conditions = [], array $columns = ['*'])
    {
        $query = $this->model->select($columns);

        foreach ($conditions as $condition) {
            $this->applyCondition($query, $condition);
        }

        return $query->get();
    }

    /**
     * Temukan data berdasarkan ID
     *
     * @param mixed $id
     * @param array $columns
     * @return Model
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->model->select($columns)->findOrFail($id);
    }

    /**
     * Buat data baru
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Perbarui data berdasarkan ID
     *
     * @param array $data
     * @param mixed $identifier
     * @return Model
     */
    public function update(array $data, $identifier = null)
    {
        $query = $this->model->newQuery();

        if ($identifier !== null) {
            if (is_array($identifier)) {
                foreach ($identifier as $condition) {
                    $this->applyCondition($query, $condition);
                }

                return $query->update($data);
            }

            $instance = $this->find($identifier);
            return $instance->update($data);
        }

        return false;
    }

    /**
     * Hapus data berdasarkan ID
     *
     * @param mixed $identifier
     * @return bool|null
     */
    public function delete($identifier)
    {
        $query = $this->model->newQuery();

        if (is_array($identifier)) {
            foreach ($identifier as $condition) {
                $this->applyCondition($query, $condition);
            }
            return $query->delete();
        }

        $instance = $this->find($identifier);
        return $instance->delete();
    }
}
