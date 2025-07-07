<?php

namespace Sportmaster\Api\Request;

/**
 * Request object for creating FBS stock import tasks.
 */
class FbsStocksCreateImportTaskRequest
{
    private string $warehouseId;
    private array $stocks;

    /**
     * FbsStocksCreateImportTaskRequest constructor.
     *
     * @param string $warehouseId Warehouse ID (1–14 digits).
     * @param array $stocks Array of StockItem objects.
     * @throws \InvalidArgumentException If warehouseId or stocks are invalid.
     */
    public function __construct(string $warehouseId, array $stocks)
    {
        if (!preg_match('/^\d{1,14}$/', $warehouseId)) {
            throw new \InvalidArgumentException('Invalid warehouseId format, must be 1–14 digits');
        }
        if (empty($stocks) || count($stocks) > 1000) {
            throw new \InvalidArgumentException('Stocks array must be non-empty and contain up to 1000 items');
        }
        foreach ($stocks as $stock) {
            if (!$stock instanceof StockItem) {
                throw new \InvalidArgumentException('All stock items must be instances of StockItem');
            }
        }
        $this->warehouseId = $warehouseId;
        $this->stocks = $stocks;
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
     * Gets the stock items.
     *
     * @return array
     */
    public function getStocks(): array
    {
        return $this->stocks;
    }
}