<?php

namespace App\Contracts\Services\Filters;

use App\DTO\MainDTO;
use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function search(MainDTO $searchDTO, string $modelName): Builder;
}
