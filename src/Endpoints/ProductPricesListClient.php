<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\ProductPricesListRequest;
use Sportmaster\Api\Response\ProductPricesListResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for listing product prices from the Sportmaster Seller API.
 */
class ProductPricesListClient
{
    private Client $client;

    /**
     * ProductPricesListClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a list of product prices.
     *
     * @param ProductPricesListRequest $request Request object with offer IDs and pagination parameters.
     * @return ProductPricesListResponse Response object containing the list of prices and pagination.
     * @throws ApiException If the request fails.
     */
    public function list(ProductPricesListRequest $request): ProductPricesListResponse
    {
        try {
            $data = array_filter([
                'offerIds' => $request->getOfferIds(),
                'limit' => $request->getLimit(),
                'offset' => $request->getOffset(),
            ]);

            $response = $this->client->request('POST', '/api/v1/product/prices/list', $data);

            return new ProductPricesListResponse(
                $response['productPrices'] ?? [],
                $response['pagination'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to list product prices: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}