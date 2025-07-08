<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for retrieving stock information for a warehouse.
 */
class FbsStocksListResponse
{
    private array $stocks;
    private array $pagination;

    /**
     * FbsStocksListResponse constructor.
     *
     * @param array $stocks List of stock details.
     * @param array $pagination Pagination details (limit, offset, total).
     */
    public function __construct(array $stocks, array $pagination)
    {
        $this->stocks = $stocks;
        $this->pagination = $pagination;
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
     * Gets the pagination details.
     *
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }
}