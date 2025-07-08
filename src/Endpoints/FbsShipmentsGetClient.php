<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Response\FbsShipmentsGetResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for retrieving detailed information about an FBS shipment from the Sportmaster Seller API (Beta).
 */
class FbsShipmentsGetClient
{
    private Client $client;

    /**
     * FbsShipmentsGetClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves detailed information about an FBS shipment by its ID.
     *
     * @param string $shipmentId Shipment ID (1–14 digits).
     * @return FbsShipmentsGetResponse Response containing shipment details.
     * @throws ApiException If the request fails or shipmentId is invalid.
     */
    public function get(string $shipmentId): FbsShipmentsGetResponse
    {
        if (!preg_match('/^\d{1,14}$/', $shipmentId)) {
            throw new ApiException('Invalid shipmentId format, must be 1–14 digits', 400);
        }

        try {
            $response = $this->client->request('GET', "/api/v1/fbs/shipments/{$shipmentId}");

            return new FbsShipmentsGetResponse(
                $response['id'] ?? null,
                $response['status'] ?? null,
                $response['orderNumber'] ?? null,
                $response['createDate'] ?? null,
                $response['planedDate'] ?? null,
                $response['lastStatusDate'] ?? null,
                $response['warehouse'] ?? [],
                $response['dropOffPoint'] ?? [],
                $response['courierCompany'] ?? [],
                $response['totalCost'] ?? [],
                $response['shippingGroup'] ?? [],
                $response['orderStatus'] ?? [],
                $response['shippingMethod'] ?? null,
                $response['isMultiPackage'] ?? false,
                $response['packages'] ?? [],
                $response['rejectedProducts'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to get FBS shipment: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}