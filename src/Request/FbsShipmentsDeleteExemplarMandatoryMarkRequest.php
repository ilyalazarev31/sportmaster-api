<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for deleting an exemplar mandatory mark from a specific FBS shipment.
 */
class FbsShipmentsDeleteExemplarMandatoryMarkRequest
{
    private string $exemplarId;

    /**
     * FbsShipmentsDeleteExemplarMandatoryMarkRequest constructor.
     *
     * @param string $exemplarId Exemplar ID (1–20 digits).
     * @throws \InvalidArgumentException If exemplarId is invalid.
     */
    public function __construct(string $exemplarId)
    {
        if (!preg_match('/^\d{1,20}$/', $exemplarId)) {
            throw new InvalidArgumentException('Invalid exemplarId format, must be 1–20 digits');
        }
        $this->exemplarId = $exemplarId;
    }

    /**
     * Gets the exemplar ID.
     *
     * @return string
     */
    public function getExemplarId(): string
    {
        return $this->exemplarId;
    }
}