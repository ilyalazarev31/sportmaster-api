<?php

namespace Sportmaster\Api\Response;

use InvalidArgumentException;

/**
 * Response object for creating a shipping group.
 */
class FbsShippingGroupsResponse
{
    private ?string $shippingGroupId;
    private array $shipmentIds;
    private ?string $courierCompanyId;

    /**
     * FbsShippingGroupsResponse constructor.
     *
     * @param string|null $shippingGroupId Shipping group ID (1–20 digits).
     * @param array $shipmentIds List of shipment IDs.
     * @param string|null $courierCompanyId Courier company ID (1–20 digits).
     * @throws \InvalidArgumentException If shippingGroupId or courierCompanyId is invalid.
     */
    public function __construct(?string $shippingGroupId, array $shipmentIds, ?string $courierCompanyId)
    {
        if ($shippingGroupId !== null && !preg_match('/^\d{1,20}$/', $shippingGroupId)) {
            throw new InvalidArgumentException('Invalid shippingGroupId format, must be 1–20 digits');
        }
        if ($courierCompanyId !== null && !preg_match('/^\d{1,20}$/', $courierCompanyId)) {
            throw new InvalidArgumentException('Invalid courierCompanyId format, must be 1–20 digits');
        }
        $this->shippingGroupId = $shippingGroupId;
        $this->shipmentIds = $shipmentIds;
        $this->courierCompanyId = $courierCompanyId;
    }

    /**
     * Gets the shipping group ID.
     *
     * @return string|null
     */
    public function getShippingGroupId(): ?string
    {
        return $this->shippingGroupId;
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
     * @return string|null
     */
    public function getCourierCompanyId(): ?string
    {
        return $this->courierCompanyId;
    }
}