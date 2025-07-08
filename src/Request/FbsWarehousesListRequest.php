<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for retrieving a list of seller's warehouses.
 */
class FbsWarehousesListRequest
{
    private int $limit;
    private int $offset;

    /**
     * FbsWarehousesListRequest constructor.
     *
     * @param int $limit Maximum number of items to return (0–1000, default 20).
     * @param int $offset Offset from the first item (>= 0, default 0).
     * @throws \InvalidArgumentException If limit or offset is invalid.
     */
    public function __construct(int $limit = 20, int $offset = 0)
    {
        if ($limit < 0 || $limit > 1000) {
            throw new InvalidArgumentException('Limit must be between 0 and 1000');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('Offset must be greater than or equal to 0');
        }
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Gets the limit.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Gets the offset.
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}