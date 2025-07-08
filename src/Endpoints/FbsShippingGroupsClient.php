<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShippingGroupsRequest;
use Sportmaster\Api\Response\FbsShippingGroupsResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for creating a shipping group in the Sportmaster Seller API (Beta).
 */
class FbsShippingGroupsClient
{
    private Client $client;

    /**
     * FbsShippingGroupsClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a shipping group with specified shipments.
     *
     * @param FbsShippingGroupsRequest $request Request object with shipment IDs and courier company ID.
     * @return FbsShippingGroupsResponse Response containing the created shipping group details.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails.
     */
    public function create(FbsShippingGroupsRequest $request): FbsShippingGroupsResponse
    {
        try {
            $data = [
                'shipmentIds' => $request->getShipmentIds(),
                'courierCompanyId' => $request->getCourierCompanyId(),
            ];

            $response = $this->client->request('POST', '/api/v1/fbs/shipping-groups', $data);

            return new FbsShippingGroupsResponse(
                $response['shippingGroupId'] ?? null,
                $response['shipmentIds'] ?? [],
                $response['courierCompanyId'] ?? null
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to create shipping group: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}