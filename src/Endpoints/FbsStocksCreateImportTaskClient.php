<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsStocksCreateImportTaskRequest;
use Sportmaster\Api\Response\FbsStocksCreateImportTaskResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for creating FBS stock import tasks in the Sportmaster Seller API.
 */
class FbsStocksCreateImportTaskClient
{
    private Client $client;

    /**
     * FbsStocksCreateImportTaskClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a task to import FBS stocks.
     *
     * @param FbsStocksCreateImportTaskRequest $request Request object with warehouse ID and stock items.
     * @return FbsStocksCreateImportTaskResponse Response containing the task ID.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails.
     */
    public function create(FbsStocksCreateImportTaskRequest $request): FbsStocksCreateImportTaskResponse
    {
        try {
            $data = [
                'warehouseId' => $request->getWarehouseId(),
                'stocks' => array_map(static function ($item) {
                    return [
                        'offerId' => $item->getOfferId(),
                        'warehouseStock' => $item->getWarehouseStock(),
                    ];
                }, $request->getStocks()),
            ];

            $response = $this->client->request('POST', '/api/v1/fbs/stocks/create-import-task', $data);

            return new FbsStocksCreateImportTaskResponse($response['taskId'] ?? null);
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to create FBS stock import task: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}