<?php

namespace Future\LaraAdmin\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    public Model $model;

    public Builder $query;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->makeModel();
        $this->makeBuilder();
    }

    /**
     * Defining model class
     * @return string
     */
    abstract protected function model(): string;

    /**
     * @return Model
     * @throws Exception
     */
    private function makeModel(): Model
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    protected function makeBuilder(): Builder
    {
        return $this->query = $this->model->newQuery();
    }

    /**
     * @param $attributes
     * @param array $value
     * @return Model
     */
    public function updateOrCreate($attributes, $value = []): Model
    {
        return $this->model()::updateOrCreate(
            $attributes,
            $value
        );
    }

    /**
     * @param $field
     * @param null $value
     * @param string[] $columns
     * @return Collection
     */
    public function findByField($field, $value = null, $columns = ['*']): Collection
    {
        return $this->query->where($field, '=', $value)->get($columns);
    }

    public function all($columns = ['*']): Collection
    {
        return $this->query->get($columns);
    }
}
