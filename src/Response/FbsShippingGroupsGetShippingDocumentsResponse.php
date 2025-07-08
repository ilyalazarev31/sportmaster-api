<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for retrieving shipping documents for a shipping group.
 */
class FbsShippingGroupsGetShippingDocumentsResponse
{
    private array $documents;

    /**
     * FbsShippingGroupsGetShippingDocumentsResponse constructor.
     *
     * @param array $documents List of document details (e.g., type, url).
     */
    public function __construct(array $documents)
    {
        $this->documents = $documents;
    }

    /**
     * Gets the list of documents.
     *
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }
}