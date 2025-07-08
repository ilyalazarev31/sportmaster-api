<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Stock item for FBS stock import tasks.
 */
class StockItem
{
    private string $offerId;
    private int $warehouseStock;

    /**
     * StockItem constructor.
     *
     * @param string $offerId Product offer ID (1–50 characters).
     * @param int $warehouseStock Stock quantity (>= 0).
     * @throws \InvalidArgumentException If offerId or warehouseStock is invalid.
     */
    public function __construct(string $offerId, int $warehouseStock)
    {
        if (!preg_match('/^[A-Za-zА-Яа-я0-9 #+*-.\/^_"]{1,50}$/u', $offerId)) {
            throw new InvalidArgumentException('Invalid offerId format, must be 1–50 characters');
        }
        if ($warehouseStock < 0) {
            throw new InvalidArgumentException('Warehouse stock must be greater than or equal to 0');
        }
        $this->offerId = $offerId;
        $this->warehouseStock = $warehouseStock;
    }

    /**
     * Gets the offer ID.
     *
     * @return string
     */
    public function getOfferId(): string
    {
        return $this->offerId;
    }

    /**
     * Gets the warehouse stock quantity.
     *
     * @return int
     */
    public function getWarehouseStock(): int
    {
        return $this->warehouseStock;
    }
}