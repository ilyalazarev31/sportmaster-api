<?php

namespace Sportmaster\Api\Response;

use InvalidArgumentException;

/**
 * Response object for changing packages for a specific FBS shipment.
 */
class FbsShipmentsChangePackagesResponse
{
    private ?string $shipmentId;
    private array $packages;

    /**
     * FbsShipmentsChangePackagesResponse constructor.
     *
     * @param string|null $shipmentId Shipment ID (1–20 digits).
     * @param array $packages List of updated package details.
     * @throws \InvalidArgumentException If shipmentId is invalid.
     */
    public function __construct(?string $shipmentId, array $packages)
    {
        if ($shipmentId !== null && !preg_match('/^\d{1,20}$/', $shipmentId)) {
            throw new InvalidArgumentException('Invalid shipmentId format, must be 1–20 digits');
        }
        $this->shipmentId = $shipmentId;
        $this->packages = $packages;
    }

    /**
     * Gets the shipment ID.
     *
     * @return string|null
     */
    public function getShipmentId(): ?string
    {
        return $this->shipmentId;
    }

    /**
     * Gets the updated package details.
     *
     * @return array
     */
    public function getPackages(): array
    {
        return $this->packages;
    }
}