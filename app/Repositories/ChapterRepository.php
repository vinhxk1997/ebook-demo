<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;

class ChapterRepository extends BaseRepository
{
    public function published()
    {
        $this->model = $this->model->published();

        return $this;
    }
}
