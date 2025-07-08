<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsWarehousesListRequest;
use Sportmaster\Api\Response\FbsWarehousesListResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for retrieving a list of seller's warehouses from the Sportmaster Seller API.
 */
class FbsWarehousesListClient
{
    private Client $client;

    /**
     * FbsWarehousesListClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a list of seller's warehouses.
     *
     * @param FbsWarehousesListRequest $request Request object with limit and offset.
     * @return FbsWarehousesListResponse Response containing the list of warehouses and pagination.
     * @throws ApiException If the request fails.
     */
    public function list(FbsWarehousesListRequest $request): FbsWarehousesListResponse
    {
        try {
            $data = [
                'limit' => $request->getLimit(),
                'offset' => $request->getOffset(),
            ];

            $response = $this->client->request('POST', '/api/v1/fbs/warehouses/list', $data);

            return new FbsWarehousesListResponse(
                $response['items'] ?? [],
                $response['pagination'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to list warehouses: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}