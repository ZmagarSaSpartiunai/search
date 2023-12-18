<?php

namespace App\Contracts\Repositories;

use App\DTO\Tasks\TaskSearchDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function search(TaskSearchDTO $searchDTO): LengthAwarePaginator;
}
