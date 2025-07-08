<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for retrieving a list of seller's warehouses.
 */
class FbsWarehousesListResponse
{
    private array $items;
    private array $pagination;

    /**
     * FbsWarehousesListResponse constructor.
     *
     * @param array $items List of warehouse details.
     * @param array $pagination Pagination details (limit, offset, total).
     */
    public function __construct(array $items, array $pagination)
    {
        $this->items = $items;
        $this->pagination = $pagination;
    }

    /**
     * Gets the list of warehouses.
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Gets the pagination details.
     *
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }
}