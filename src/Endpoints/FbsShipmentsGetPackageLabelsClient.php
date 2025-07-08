<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShipmentsGetPackageLabelsRequest;
use Sportmaster\Api\Response\FbsShipmentsGetPackageLabelsResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for retrieving package labels for FBS shipments from the Sportmaster Seller API (Beta).
 */
class FbsShipmentsGetPackageLabelsClient
{
    private Client $client;

    /**
     * FbsShipmentsGetPackageLabelsClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves package labels for specified FBS shipments.
     *
     * @param FbsShipmentsGetPackageLabelsRequest $request Request object with shipment IDs.
     * @return FbsShipmentsGetPackageLabelsResponse Response containing file content and results.
     * @throws ApiException If the request fails.
     */
    public function getPackageLabels(FbsShipmentsGetPackageLabelsRequest $request): FbsShipmentsGetPackageLabelsResponse
    {
        try {
            $data = [
                'shipmentIds' => $request->getShipmentIds(),
            ];

            $response = $this->client->request('POST', '/api/v1/fbs/shipments/get-package-labels', $data);

            return new FbsShipmentsGetPackageLabelsResponse(
                $response['fileContent'] ?? null,
                $response['fileName'] ?? null,
                $response['getPackageLabelResults'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to get package labels: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}