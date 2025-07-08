<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for setting a mandatory mark on an exemplar in an FBS shipment.
 */
class FbsShipmentsSetExemplarMandatoryMarkRequest
{
    private string $exemplarId;
    private string $mandatoryMark;

    /**
     * FbsShipmentsSetExemplarMandatoryMarkRequest constructor.
     *
     * @param string $exemplarId Exemplar ID (1–14 digits).
     * @param string $mandatoryMark Mandatory mark (≤ 2000 characters).
     * @throws \InvalidArgumentException If exemplarId or mandatoryMark is invalid.
     */
    public function __construct(string $exemplarId, string $mandatoryMark)
    {
        if (!preg_match('/^\d{1,14}$/', $exemplarId)) {
            throw new InvalidArgumentException('Invalid exemplarId format, must be 1–14 digits');
        }
        if (strlen($mandatoryMark) > 2000) {
            throw new InvalidArgumentException('Mandatory mark must be 2000 characters or less');
        }
        $this->exemplarId = $exemplarId;
        $this->mandatoryMark = $mandatoryMark;
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

    /**
     * Gets the mandatory mark.
     *
     * @return string
     */
    public function getMandatoryMark(): string
    {
        return $this->mandatoryMark;
    }
}