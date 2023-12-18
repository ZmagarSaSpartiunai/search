<?php

namespace App\DTO;

use ReflectionClass;

class MainDTO
{
    /**
     * @param array $filters
     * @return self
     * @throws \ReflectionException
     */
    public static function from(?array $filters): self
    {
        $className = get_called_class();
        // Define the order of attributes in the constructor
        $constructorParameters = (new ReflectionClass($className))->getConstructor()->getParameters();
        $orderedFilters = [];
        // get the correct order in the array $filters
        foreach ($constructorParameters as $parameter) {
            $parameterName = $parameter->getName();
            $orderedFilters[] = $filters[$parameterName] ??
                ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null);
        }

        return new $className(...$orderedFilters);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
