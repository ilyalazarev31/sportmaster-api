<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShipmentsChangePackagesRequest;
use Sportmaster\Api\Response\FbsShipmentsChangePackagesResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for changing packages for a specific FBS shipment in the Sportmaster Seller API (Beta).
 */
class FbsShipmentsChangePackagesClient
{
    private Client $client;

    /**
     * FbsShipmentsChangePackagesClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Changes packages for a specified FBS shipment.
     *
     * @param string $shipmentId Shipment ID (1–20 digits).
     * @param FbsShipmentsChangePackagesRequest $request Request object with package details.
     * @return FbsShipmentsChangePackagesResponse Response containing the updated shipment details.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails or shipmentId is invalid.
     */
    public function changePackages(string $shipmentId, FbsShipmentsChangePackagesRequest $request): FbsShipmentsChangePackagesResponse
    {
        if (!preg_match('/^\d{1,20}$/', $shipmentId)) {
            throw new ApiException('Invalid shipmentId format, must be 1–20 digits', 400);
        }

        try {
            $data = [
                'packages' => $request->getPackages(),
            ];

            $response = $this->client->request('POST', "/api/v1/fbs/shipments/{$shipmentId}/change-packages", $data);

            return new FbsShipmentsChangePackagesResponse(
                $response['shipmentId'] ?? null,
                $response['packages'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to change packages for shipment {$shipmentId}: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}