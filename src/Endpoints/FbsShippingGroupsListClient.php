<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShippingGroupsListRequest;
use Sportmaster\Api\Response\FbsShippingGroupsListResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for retrieving a list of shipping groups from the Sportmaster Seller API (Beta).
 */
class FbsShippingGroupsListClient
{
    private Client $client;

    /**
     * FbsShippingGroupsListClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a list of shipping groups.
     *
     * @param FbsShippingGroupsListRequest $request Request object with shipping group IDs, shipment IDs, statuses, limit, and offset.
     * @return FbsShippingGroupsListResponse Response containing the list of shipping groups and pagination.
     * @throws ApiException If the request fails.
     */
    public function list(FbsShippingGroupsListRequest $request): FbsShippingGroupsListResponse
    {
        try {
            $data = array_filter([
                'shippingGroupIds' => $request->getShippingGroupIds(),
                'shipmentIds' => $request->getShipmentIds(),
                'statuses' => $request->getStatuses(),
                'limit' => $request->getLimit(),
                'offset' => $request->getOffset(),
            ], static fn($value) => $value !== null && (!is_array($value) || !empty($value)));

            $response = $this->client->request('POST', '/api/v1/fbs/shipping-groups/list', $data);

            return new FbsShippingGroupsListResponse(
                $response['shippingGroups'] ?? [],
                $response['pagination'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to list shipping groups: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}