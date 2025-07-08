<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\ProductPricesCreateImportTaskRequest;
use Sportmaster\Api\Response\ProductPricesCreateImportTaskResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for creating a product prices import task in the Sportmaster Seller API.
 */
class ProductPricesCreateImportTaskClient
{
    private Client $client;

    /**
     * ProductPricesCreateImportTaskClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a product prices import task.
     *
     * @param ProductPricesCreateImportTaskRequest $request Request object with price data.
     * @return ProductPricesCreateImportTaskResponse Response object containing the task ID.
     * @throws ApiException If the request fails.
     */
    public function create(ProductPricesCreateImportTaskRequest $request): ProductPricesCreateImportTaskResponse
    {
        try {
            $data = [
                'productPrices' => array_map(static fn($price) => [
                    'offerId' => $price->getOfferId(),
                    'price' => $price->getPrice(),
                    'discountPrice' => $price->getDiscountPrice(),
                ], $request->getProductPrices()),
            ];

            $response = $this->client->request('POST', '/api/v1/product/prices/create-import-task', $data);

            return new ProductPricesCreateImportTaskResponse($response['taskId'] ?? null);
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to create prices import task: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}