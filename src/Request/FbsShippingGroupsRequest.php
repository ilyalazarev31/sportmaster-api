<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for creating a shipping group.
 */
class FbsShippingGroupsRequest
{
    private array $shipmentIds;
    private string $courierCompanyId;

    /**
     * FbsShippingGroupsRequest constructor.
     *
     * @param array $shipmentIds Array of shipment IDs (1–20 digits, non-empty, max 1000).
     * @param string $courierCompanyId Courier company ID (1–20 digits).
     * @throws \InvalidArgumentException If shipmentIds or courierCompanyId is invalid.
     */
    public function __construct(array $shipmentIds, string $courierCompanyId)
    {
        if (empty($shipmentIds)) {
            throw new InvalidArgumentException('Shipment IDs array must not be empty');
        }
        if (count($shipmentIds) > 1000) {
            throw new InvalidArgumentException('Shipment IDs array must not exceed 1000 items');
        }
        foreach ($shipmentIds as $shipmentId) {
            if (!is_string($shipmentId) || !preg_match('/^\d{1,20}$/', $shipmentId)) {
                throw new InvalidArgumentException('Each shipment ID must be a string of 1–20 digits');
            }
        }
        if (!preg_match('/^\d{1,20}$/', $courierCompanyId)) {
            throw new InvalidArgumentException('Invalid courierCompanyId format, must be 1–20 digits');
        }
        $this->shipmentIds = array_unique($shipmentIds);
        $this->courierCompanyId = $courierCompanyId;
    }

    /**
     * Gets the shipment IDs.
     *
     * @return array
     */
    public function getShipmentIds(): array
    {
        return $this->shipmentIds;
    }

    /**
     * Gets the courier company ID.
     *
     * @return string
     */
    public function getCourierCompanyId(): string
    {
        return $this->courierCompanyId;
    }
}