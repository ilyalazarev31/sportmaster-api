<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\FbsShippingGroupsGetShippingDocumentsRequest;
use Sportmaster\Api\Response\FbsShippingGroupsGetShippingDocumentsResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for retrieving shipping documents for a shipping group from the Sportmaster Seller API (Beta).
 */
class FbsShippingGroupsGetShippingDocumentsClient
{
    private Client $client;

    /**
     * FbsShippingGroupsGetShippingDocumentsClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves shipping documents for a specified shipping group.
     *
     * @param FbsShippingGroupsGetShippingDocumentsRequest $request Request object with shipping group ID and document types.
     * @return FbsShippingGroupsGetShippingDocumentsResponse Response containing the document links.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the request fails.
     */
    public function getShippingDocuments(FbsShippingGroupsGetShippingDocumentsRequest $request): FbsShippingGroupsGetShippingDocumentsResponse
    {
        try {
            $data = [
                'shippingGroupId' => $request->getShippingGroupId(),
                'documentTypes' => $request->getDocumentTypes(),
            ];

            $response = $this->client->request('POST', '/api/v1/fbs/shipping-groups/get-shipping-documents', $data);

            return new FbsShippingGroupsGetShippingDocumentsResponse(
                $response['documents'] ?? []
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Failed to get shipping documents for shipping group {$request->getShippingGroupId()}: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}