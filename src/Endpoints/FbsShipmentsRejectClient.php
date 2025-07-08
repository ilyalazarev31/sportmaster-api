<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShipmentsRejectRequest;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for rejecting an FBS shipment in the Sportmaster Seller API (Beta).
 */
class FbsShipmentsRejectClient
{
    private Client $client;

    /**
     * FbsShipmentsRejectClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Rejects an FBS shipment with a specified reason.
     *
     * @param FbsShipmentsRejectRequest $request Request object with shipment ID and reason.
     * @return bool True if the operation is successful.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails.
     */
    public function reject(FbsShipmentsRejectRequest $request): bool
    {
        try {
            $data = [
                'shipmentId' => $request->getShipmentId(),
                'reason' => $request->getReason(),
            ];

            $this->client->request('POST', '/api/v1/fbs/shipments/reject', $data);

            return true;
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to reject shipment {$request->getShipmentId()}: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}