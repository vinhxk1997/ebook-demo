<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function where($conditions, $operator = null, $value = null);

    public function whereIn($column, array $values);

    public function orWhere($conditions, $operator = null, $value = null);

    public function orderBy($column, $direction = 'asc');

    public function limit($limit);

    public function offset($offset);

    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false);

    public function count();

    public function with($relations);

    public function withCount($relations);

    public function select($columns = ['*']);

    public function selectRaw($expression, array $bindings = []);

    public function all();
    
    public function get();

    public function first();

    public function paginate($perPage = null);

    public function find($id);

    public function findOrFail($id);

    public function create(array $data);

    public function update(array $data);

    public function delete($id);

    public function truncate();

    public function toSql();
}
