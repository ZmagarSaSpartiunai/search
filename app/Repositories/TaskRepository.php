<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Services\Filters\FilterInterface;
use App\Contracts\Services\Filters\Tasks\TaskFilterServiceInterface;
use App\DTO\Tasks\TaskSearchDTO;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{

    public function __construct(
        protected TaskFilterServiceInterface $searchService,
    )
    {
    }

    public function search(TaskSearchDTO $searchDTO): LengthAwarePaginator
    {
        return $this->searchService->search($searchDTO, Task::class)->paginate()->withQueryString();
    }
}
