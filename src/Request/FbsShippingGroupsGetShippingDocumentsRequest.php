<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for retrieving shipping documents for a shipping group.
 */
class FbsShippingGroupsGetShippingDocumentsRequest
{
    private string $shippingGroupId;
    private array $documentTypes;

    /**
     * FbsShippingGroupsGetShippingDocumentsRequest constructor.
     *
     * @param string $shippingGroupId Shipping group ID (1–20 digits).
     * @param array $documentTypes Array of document types (non-empty).
     * @throws \InvalidArgumentException If shippingGroupId or documentTypes is invalid.
     */
    public function __construct(string $shippingGroupId, array $documentTypes)
    {
        if (!preg_match('/^\d{1,20}$/', $shippingGroupId)) {
            throw new InvalidArgumentException('Invalid shippingGroupId format, must be 1–20 digits');
        }
        if (empty($documentTypes)) {
            throw new InvalidArgumentException('Document types array must not be empty');
        }
        $validDocumentTypes = ['ACT', 'LABEL', 'INVOICE'];
        foreach ($documentTypes as $type) {
            if (!in_array($type, $validDocumentTypes, true)) {
                throw new InvalidArgumentException('Invalid document type: ' . $type);
            }
        }
        $this->shippingGroupId = $shippingGroupId;
        $this->documentTypes = array_unique($documentTypes);
    }

    /**
     * Gets the shipping group ID.
     *
     * @return string
     */
    public function getShippingGroupId(): string
    {
        return $this->shippingGroupId;
    }

    /**
     * Gets the document types.
     *
     * @return array
     */
    public function getDocumentTypes(): array
    {
        return $this->documentTypes;
    }
}