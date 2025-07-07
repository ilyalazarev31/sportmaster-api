<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsStocksListRequest;
use Sportmaster\Api\Response\FbsStocksListResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for listing FBS stocks from the Sportmaster Seller API.
 */
class FbsStocksListClient
{
    private Client $client;

    /**
     * FbsStocksListClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a list of FBS stocks for a specific warehouse.
     *
     * @param FbsStocksListRequest $request Request object with warehouse ID, limit, and offset.
     * @return FbsStocksListResponse Response containing the list of stocks and pagination.
     * @throws ApiException If the request fails.
     */
    public function list(FbsStocksListRequest $request): FbsStocksListResponse
    {
        try {
            $data = [
                'warehouseId' => $request->getWarehouseId(),
                'limit' => $request->getLimit(),
                'offset' => $request->getOffset(),
            ];

            $response = $this->client->request('POST', '/api/v1/fbs/stocks/list', $data);

            return new FbsStocksListResponse(
                $response['stocks'] ?? [],
                $response['pagination']['limit'] ?? null,
                $response['pagination']['offset'] ?? null,
                $response['pagination']['total'] ?? null
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to list FBS stocks: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}