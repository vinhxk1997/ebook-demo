<?php
namespace App\Repositories;

use Illuminate\Container\Container as Application;
use App\Repositories\BaseRepository;

class MetaRepository extends BaseRepository
{
    public function getCategories()
    {
        return $this->where('type', 'category')->get();
    }

    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function findOrFailBySlug($slug)
    {
        $meta = $this->findBySlug($slug);
        if (! $meta) {
            abort(404);
        }

        return $meta;
    }

    public function findOrCreateMany($data, $key) {
        $create_data = collect();
        $this_model_class = (new \ReflectionClass($this->model))->getShortName();
        if (! is_array($data)) {
            $data = [$data];
        }
        foreach ($data as $item) {
            if ($item instanceof $this->model && (new \ReflectionClass($item))->getShortName() === $this_model_class) {
                $create_data->put($item->{$key}, $item);
            }
        }

        $find_data = $this->whereIn($key, $create_data->pluck($key))->get();
        if ($find_data->count()) {
            foreach ($find_data as $item) {
                $create_data->forget($item->{$key});
            }
        }
        if ($create_data->count()) {
            $this->model->insert($create_data->toArray());
        }

        $find_data = $find_data->merge($this->whereIn($key, $create_data->pluck($key))->get());

        return $find_data;
    }
}
