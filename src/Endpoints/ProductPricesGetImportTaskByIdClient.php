<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\ProductPricesGetImportTaskByIdRequest;
use Sportmaster\Api\Response\ProductPricesGetImportTaskByIdResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for retrieving a product prices import task status from the Sportmaster Seller API.
 */
class ProductPricesGetImportTaskByIdClient
{
    private Client $client;

    /**
     * ProductPricesGetImportTaskByIdClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a product prices import task status by ID.
     *
     * @param ProductPricesGetImportTaskByIdRequest $request Request object with task ID.
     * @return ProductPricesGetImportTaskByIdResponse Response object containing task details.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails.
     */
    public function get(ProductPricesGetImportTaskByIdRequest $request): ProductPricesGetImportTaskByIdResponse
    {
        try {
            $data = [
                'taskId' => $request->getTaskId(),
            ];

            $response = $this->client->request('POST', '/api/v1/product/prices/import-task', $data);

            return new ProductPricesGetImportTaskByIdResponse(
                $response['taskId'] ?? null,
                $response['status'] ?? null,
                $response['createdAt'] ?? null,
                $response['updatedAt'] ?? null,
                $response['productPrices'] ?? null
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to get prices import task status: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}