<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for listing FBS stocks.
 */
class FbsStocksListResponse
{
    private array $stocks;
    private ?int $limit;
    private ?int $offset;
    private ?int $total;

    /**
     * FbsStocksListResponse constructor.
     *
     * @param array $stocks List of stock items with their details.
     * @param int|null $limit Maximum number of items returned.
     * @param int|null $offset Offset used for pagination.
     * @param int|null $total Total number of items available.
     */
    public function __construct(array $stocks, ?int $limit, ?int $offset, ?int $total)
    {
        $this->stocks = $stocks;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->total = $total;
    }

    /**
     * Gets the list of stocks.
     *
     * @return array
     */
    public function getStocks(): array
    {
        return $this->stocks;
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