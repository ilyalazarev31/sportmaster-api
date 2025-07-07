<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for listing product prices.
 */
class ProductPricesListResponse
{
    private array $productPrices;
    private array $pagination;

    /**
     * ProductPricesListResponse constructor.
     *
     * @param array $productPrices Array of price data.
     * @param array $pagination Pagination data (limit, offset, total).
     */
    public function __construct(array $productPrices, array $pagination)
    {
        $this->productPrices = $productPrices;
        $this->pagination = $pagination;
    }

    /**
     * Gets the list of product prices.
     *
     * @return array
     */
    public function getProductPrices(): array
    {
        return $this->productPrices;
    }

    /**
     * Gets the pagination data.
     *
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }
}