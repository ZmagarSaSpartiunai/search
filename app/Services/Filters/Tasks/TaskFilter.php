<?php

namespace App\Services\Filters\Tasks;

use App\Contracts\Services\Filters\Tasks\TaskFilterServiceInterface;
use App\Services\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends MainFilter implements TaskFilterServiceInterface
{
    public function status(Builder &$query)
    {
        $this->addCondition(__FUNCTION__, $query);
    }

    public function estimate(Builder &$query)
    {
        $this->addCondition(__FUNCTION__, $query);
    }

    public function content(Builder &$query)
    {
        $this->addCondition(__FUNCTION__, $query);
    }
}
