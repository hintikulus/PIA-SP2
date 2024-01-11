<?php

namespace App\Model\Database\Transformer;

/**
 * @template T
 */
abstract class AbstractTransformer
{
    /**
     * @param T $item
     * @return array<mixed>
     */
    public abstract function transform($item): array;

    /**
     * @param array<T> $array
     * @return array<mixed>
     */
    public function transformCollection($array): array
    {
        $transformed = [];

        foreach ($array as $item)
        {
            $transformed[] = $this->transform($item);
        }

        return $transformed;
    }
}
