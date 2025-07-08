<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShipmentsSetExemplarMandatoryMarkRequest;
use Sportmaster\Api\Response\FbsShipmentsSetExemplarMandatoryMarkResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for setting mandatory mark on an exemplar in an FBS shipment from the Sportmaster Seller API (Beta).
 */
class FbsShipmentsSetExemplarMandatoryMarkClient
{
    private Client $client;

    /**
     * FbsShipmentsSetExemplarMandatoryMarkClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sets a mandatory mark on an exemplar in an FBS shipment.
     *
     * @param string $shipmentId Shipment ID (1–14 digits).
     * @param FbsShipmentsSetExemplarMandatoryMarkRequest $request Request object with exemplar ID and mandatory mark.
     * @return FbsShipmentsSetExemplarMandatoryMarkResponse Response containing verification results.
     * @throws ApiException If the request fails or shipmentId is invalid.
     */
    public function setExemplarMandatoryMark(string $shipmentId, FbsShipmentsSetExemplarMandatoryMarkRequest $request): FbsShipmentsSetExemplarMandatoryMarkResponse
    {
        if (!preg_match('/^\d{1,14}$/', $shipmentId)) {
            throw new ApiException('Invalid shipmentId format, must be 1–14 digits', 400);
        }

        try {
            $data = [
                'exemplarId' => $request->getExemplarId(),
                'mandatoryMark' => $request->getMandatoryMark(),
            ];

            $response = $this->client->request('POST', "/api/v1/fbs/shipments/{$shipmentId}/set-exemplar-mandatory-mark", $data);

            return new FbsShipmentsSetExemplarMandatoryMarkResponse(
                $response['isMandatoryMarkSet'] ?? false,
                $response['verificationErrors'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to set mandatory mark: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}