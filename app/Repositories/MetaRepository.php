<?php
namespace App\Repositories;

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
}
