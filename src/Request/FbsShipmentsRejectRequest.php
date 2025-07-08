<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for rejecting an FBS shipment.
 */
class FbsShipmentsRejectRequest
{
    private string $shipmentId;
    private string $reason;

    /**
     * FbsShipmentsRejectRequest constructor.
     *
     * @param string $shipmentId Shipment ID (1–20 digits).
     * @param string $reason Rejection reason (1–255 characters).
     * @throws \InvalidArgumentException If shipmentId or reason is invalid.
     */
    public function __construct(string $shipmentId, string $reason)
    {
        if (!preg_match('/^\d{1,20}$/', $shipmentId)) {
            throw new InvalidArgumentException('Invalid shipmentId format, must be 1–20 digits');
        }
        if ($reason === '' || strlen($reason) > 255) {
            throw new InvalidArgumentException('Reason must be 1–255 characters');
        }
        $this->shipmentId = $shipmentId;
        $this->reason = $reason;
    }

    /**
     * Gets the shipment ID.
     *
     * @return string
     */
    public function getShipmentId(): string
    {
        return $this->shipmentId;
    }

    /**
     * Gets the rejection reason.
     *
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }
}