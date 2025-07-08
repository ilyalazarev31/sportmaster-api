<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for retrieving package labels for FBS shipments.
 */
class FbsShipmentsGetPackageLabelsRequest
{
    private array $shipmentIds;

    /**
     * FbsShipmentsGetPackageLabelsRequest constructor.
     *
     * @param array $shipmentIds Array of shipment IDs (1–14 digits, max 10 items).
     * @throws \InvalidArgumentException If shipmentIds are invalid.
     */
    public function __construct(array $shipmentIds)
    {
        if (empty($shipmentIds)) {
            throw new InvalidArgumentException('Shipment IDs array must not be empty');
        }
        if (count($shipmentIds) > 10) {
            throw new InvalidArgumentException('Shipment IDs array must not exceed 10 items');
        }
        foreach ($shipmentIds as $id) {
            if (!is_string($id) || !preg_match('/^\d{1,14}$/', $id)) {
                throw new InvalidArgumentException('Each shipment ID must be a string of 1–14 digits');
            }
        }
        $this->shipmentIds = array_unique($shipmentIds);
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
}