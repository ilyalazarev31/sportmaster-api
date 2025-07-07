<?php

namespace Sportmaster\Api\Request;

/**
 * Request object for listing FBS stocks.
 */
class FbsStocksListRequest
{
    private string $warehouseId;
    private int $limit;
    private int $offset;

    /**
     * FbsStocksListRequest constructor.
     *
     * @param string $warehouseId Warehouse ID (1–14 digits).
     * @param int $limit Maximum number of items to return (0–1000).
     * @param int $offset Offset for pagination (>= 0).
     * @throws \InvalidArgumentException If warehouseId, limit, or offset is invalid.
     */
    public function __construct(string $warehouseId, int $limit = 20, int $offset = 0)
    {
        if (!preg_match('/^\d{1,14}$/', $warehouseId)) {
            throw new \InvalidArgumentException('Invalid warehouseId format, must be 1–14 digits');
        }
        if ($limit < 0 || $limit > 1000) {
            throw new \InvalidArgumentException('Limit must be between 0 and 1000');
        }
        if ($offset < 0) {
            throw new \InvalidArgumentException('Offset must be greater than or equal to 0');
        }
        $this->warehouseId = $warehouseId;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Gets the warehouse ID.
     *
     * @return string
     */
    public function getWarehouseId(): string
    {
        return $this->warehouseId;
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