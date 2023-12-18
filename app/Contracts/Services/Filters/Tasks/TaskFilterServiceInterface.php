<?php

namespace App\Contracts\Services\Filters\Tasks;

use App\DTO\Tasks\TaskSearchDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface TaskFilterServiceInterface
{
    public function status(Builder &$query);
    public function estimate(Builder &$query);
    public function content(Builder &$query);
}
