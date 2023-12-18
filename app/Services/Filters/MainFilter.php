<?php

namespace App\Services\Filters;

use App\Contracts\Services\Filters\FilterInterface;
use App\DTO\MainDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MainFilter implements FilterInterface
{
    protected MainDTO $searchDTO;
    protected Builder $query;


    /**
     * @param MainDTO $searchDTO
     * @param string $modelName
     * @return Builder
     */
    public function search(MainDTO $searchDTO, string $modelName): Builder
    {
        if (!class_exists($modelName)) {
            throw new ModelNotFoundException();
        }

        $aggregateGroupsBoolean = [];
        $this->query = $modelName::query();
        $this->searchDTO = $searchDTO;

        //divide parameters into 2 groups: and/or
        foreach ($searchDTO->toArray() as $attribute => $data) {
            if (method_exists($this, "$attribute") && isset($data['value'])) {
                $aggregateGroupsBoolean[strtolower($data['boolean'] ?? 'and')][$attribute] = $data;
            }
        }
        //first of all add in query filters with logical AND
        $this->addGroupBooleanAnd($aggregateGroupsBoolean);
        //then add in query filters with logical OR
        $this->addGroupBooleanOr($aggregateGroupsBoolean);

        return $this->query;
    }

    /**
     * @param string $field
     * @param Builder $query
     * @return void
     */
    protected function addCondition(string $field, Builder &$query): void
    {
        $value = $this->searchDTO->$field['value'];
        $operator = strtolower($this->searchDTO->$field['operator']) ?? 'is';
        $boolean = $this->searchDTO->$field['boolean'] ?? 'and';

        match ($operator) {
            'is' => $query->where($field, '=', $value, $boolean),
            'not' => $query->where($field, '!=', $value, $boolean),
            'in' => $query->whereIn($field, explode(',', $value), $boolean),
            'contains' => $query->where($field, 'LIKE', '%' . $value . '%', $boolean),
            'does_not_contain' => $query->where($field, 'NOT LIKE', '%' . $value . '%', $boolean),
            default => null,
        };

    }

    /**
     * @param array $aggregateGroupsBoolean
     * @return void
     */
    private function addGroupBooleanAnd(array $aggregateGroupsBoolean): void
    {
        if (!isset($aggregateGroupsBoolean['and'])) {
            return;
        }

        foreach ($aggregateGroupsBoolean['and'] as $attribute => $data) {
            $this->$attribute($this->query);
        }
    }

    /**
     * @param array $aggregateGroupsBoolean
     * @return void
     */
    private function addGroupBooleanOr(array $aggregateGroupsBoolean): void
    {
        if (!isset($aggregateGroupsBoolean['or'])) {
            return;
        }

        $boolean = count($aggregateGroupsBoolean['or']) > 1 ? 'and' : 'or';
        
        $this->query->where(function ($subquery) use ($aggregateGroupsBoolean) {
            foreach ($aggregateGroupsBoolean['or'] as $attribute => $data) {
                $this->$attribute($subquery);
            }
        }, boolean: $boolean);
    }
}
