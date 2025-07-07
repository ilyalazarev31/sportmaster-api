<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for listing FBS warehouses.
 */
class FbsWarehousesListResponse
{
    private array $warehouses;
    private ?int $limit;
    private ?int $offset;
    private ?int $total;

    /**
     * FbsWarehousesListResponse constructor.
     *
     * @param array $warehouses List of warehouses with their details.
     * @param int|null $limit Maximum number of items returned.
     * @param int|null $offset Offset used for pagination.
     * @param int|null $total Total number of items available.
     */
    public function __construct(array $warehouses, ?int $limit, ?int $offset, ?int $total)
    {
        $this->warehouses = $warehouses;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->total = $total;
    }

    /**
     * Gets the list of warehouses.
     *
     * @return array
     */
    public function getWarehouses(): array
    {
        return $this->warehouses;
    }

    /**
     * Gets the limit.
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Gets the offset.
     *
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Gets the total number of items.
     *
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }
}