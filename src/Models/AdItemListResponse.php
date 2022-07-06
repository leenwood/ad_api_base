<?php

namespace App\Models;

use App\Entity\Ad;

class AdItemListResponse
{
    /**
     * items in array
     * @var Ad[]
     */
    private $items;

    /**
     * В списке находятся
     * @param Ad[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Ad[]
     */
    public function getItems(): array
    {
        return $this->items;
    }


}