<?php

namespace App\DTO\Tasks;

use App\DTO\MainDTO;

class TaskSearchDTO extends MainDTO
{
    /**
     *
     * [filters] => [
     *      [status] => [
     *          [operator] => is
     *          [value] => in_progress
     *          [boolean] => or
     *      ],
     *      [content] => [
     *           [operator] => contains
     *           [value] => fox
     *           [boolean] => and
     *       ],
     *      [estimate] => [
     *          [operator] => in
     *          [value] => 1,2
     *          [boolean] => or
     *      ]
     *  ]
     *
     * @param array|null $status
     * @param array|null $estimate
     * @param array|null $content
     */
    public function __construct(
        public ?array $status,
        public ?array $estimate,
        public ?array $content,
    )
    {
    }
}
