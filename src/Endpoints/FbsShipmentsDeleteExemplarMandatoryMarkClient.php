<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShipmentsDeleteExemplarMandatoryMarkRequest;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for deleting an exemplar mandatory mark from a specific FBS shipment in the Sportmaster Seller API (Beta).
 */
class FbsShipmentsDeleteExemplarMandatoryMarkClient
{
    private Client $client;

    /**
     * FbsShipmentsDeleteExemplarMandatoryMarkClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Deletes an exemplar mandatory mark for a specified FBS shipment.
     *
     * @param string $shipmentId Shipment ID (1–20 digits).
     * @param FbsShipmentsDeleteExemplarMandatoryMarkRequest $request Request object with exemplar ID.
     * @return bool True if the operation is successful.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails or shipmentId is invalid.
     */
    public function deleteExemplarMandatoryMark(string $shipmentId, FbsShipmentsDeleteExemplarMandatoryMarkRequest $request): bool
    {
        if (!preg_match('/^\d{1,20}$/', $shipmentId)) {
            throw new ApiException('Invalid shipmentId format, must be 1–20 digits', 400);
        }

        try {
            $data = [
                'exemplarId' => $request->getExemplarId(),
            ];

            $this->client->request('POST', "/api/v1/fbs/shipments/{$shipmentId}/delete-exemplar-mandatory-mark", $data);

            return true;
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to delete exemplar mandatory mark for shipment {$shipmentId}: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}