<?php
namespace App\Repositories;

use DB;
use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RepositoryInterface;

class BaseRepository implements RepositoryInterface
{
    private $model_path = 'App\Models\\';
    protected $app;
    protected $model_name;
    public $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    protected function model()
    {
        if (!isset($this->model_name)) {
            $this->model_name = preg_replace('/Repository$/', '', class_basename($this));
        }

        return $this->model_path . $this->model_name;
    }

    public function getModelClass()
    {
        return $this->model();
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function resetModel()
    {
        $this->makeModel();
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

    public function where($conditions, $operator = null, $value = null)
    {
        $this->model = $this->model->where($conditions, $operator, $value);

        return $this;
    }

    public function whereIn($column, $values)
    {
        $this->model = $this->model->whereIn($column, $values);

        return $this;
    }

    public function orWhere($conditions, $operator = null, $value = null)
    {
        $this->model = $this->model->orWhere($conditions. $operator, $value);

        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function limit($limit)
    {
        $this->model = $this->model->limit($limit);

        return $this;
    }

    public function offset($offset)
    {
        $this->model = $this->model->offset($offset);

        return $this;
    }

    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
    {
        $this->model = $this->model->join($table, $first, $operator, $second, $type, $where);

        return $this;
    }

    public function count()
    {
        $result = $this->model->count();
        $this->resetModel();

        return $result;
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);

        return $this;
    }

    public function withTrashed()
    {
        $this->model = $this->model->withTrashed();

        return $this;
    }

    public function select($columns = ['*'])
    {
        $this->model = $this->model->select($columns);

        return $this;
    }

    public function selectRaw($expression, array $bindings = [])
    {
        $this->model = $this->model->selectRaw($expression, $bindings);

        return $this;
    }

    public function all()
    {
        return $this->model->all();
    }
    
    public function get()
    {
        $result = $this->model->get();
        $this->resetModel();

        return $result;
    }

    public function first()
    {
        $result = $this->model->first();
        $this->resetModel();

        return $result;
    }

    public function paginate($perPage = null)
    {
        $result = $this->model->paginate($perPage ?: config('app.per_page'));
        $this->resetModel();

        return $result;
    }

    public function find($id)
    {
        $result = $this->model->find($id);
        $this->resetModel();

        return $result;
    }

    public function findOrFail($id)
    {
        $result = $this->model->find($id);
        $this->resetModel();
        if (!$result) {
            abort(404);
        }
        
        return $result;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data)
    {
        $this->model->update($data);
        $this->resetModel();
    }

    public function increment($column, $amount = 1, array $extra = [])
    {
        $this->model->increment($column, $amount, $extra);
        $this->resetModel();
    }

    public function decrement($column, $amount = 1, array $extra = [])
    {
        $this->model->decrement($column, $amount, $extra);
        $this->resetModel();
    }

    public function delete($id)
    {
        $this->model->where($this->model->getKeyName(), $id)->delete();
    }

    public function truncate()
    {
        $this->model->truncate();
    }

    public function toSql()
    {
        $result = $this->model->toSql();
        $this->resetModel();

        return $result;
    }
}
