<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\DTO\Tasks\TaskSearchDTO;
use App\Http\Requests\TasksSearchRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param TasksSearchRequest $request
     * @param TaskRepositoryInterface $taskRepository
     * @return LengthAwarePaginator
     * @throws \ReflectionException
     */
    public function index(TasksSearchRequest $request, TaskRepositoryInterface $taskRepository): LengthAwarePaginator
    {
        $dto = TaskSearchDTO::from($request->input('filters'));

        return $taskRepository->search($dto);
    }
}
