<?php

namespace App\Infrastructure\Search;

use App\Infrastructure\Search\Model\ModelInterface;

class SearchResult
{
    private array $items;
    private int $total;

    /**
     * @param ModelInterface[] $results
     */
    public function __construct(array $results, int $total)
    {
        $this->items = $results;
        $this->total = $total;
    }

    /**
     * @return ModelInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
