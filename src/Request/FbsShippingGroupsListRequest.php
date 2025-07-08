<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for retrieving a list of shipping groups.
 */
class FbsShippingGroupsListRequest
{
    private array $shippingGroupIds;
    private array $shipmentIds;
    private array $statuses;
    private int $limit;
    private int $offset;

    /**
     * FbsShippingGroupsListRequest constructor.
     *
     * @param array $shippingGroupIds Array of shipping group IDs (1–20 digits, max 1000, optional).
     * @param array $shipmentIds Array of shipment IDs (1–20 digits, max 1000, optional).
     * @param array $statuses Array of statuses (non-empty).
     * @param int $limit Maximum number of items to return (0–1000, default 20).
     * @param int $offset Offset from the first item (>= 0, default 0).
     * @throws \InvalidArgumentException If parameters are invalid.
     */
    public function __construct(array $shippingGroupIds = [], array $shipmentIds = [], array $statuses, int $limit = 20, int $offset = 0)
    {
        if (!empty($shippingGroupIds)) {
            if (count($shippingGroupIds) > 1000) {
                throw new InvalidArgumentException('Shipping group IDs array must not exceed 1000 items');
            }
            foreach ($shippingGroupIds as $id) {
                if (!is_string($id) || !preg_match('/^\d{1,20}$/', $id)) {
                    throw new InvalidArgumentException('Each shipping group ID must be a string of 1–20 digits');
                }
            }
        }
        if (!empty($shipmentIds)) {
            if (count($shipmentIds) > 1000) {
                throw new InvalidArgumentException('Shipment IDs array must not exceed 1000 items');
            }
            foreach ($shipmentIds as $id) {
                if (!is_string($id) || !preg_match('/^\d{1,20}$/', $id)) {
                    throw new InvalidArgumentException('Each shipment ID must be a string of 1–20 digits');
                }
            }
        }
        if (empty($statuses)) {
            throw new InvalidArgumentException('Statuses array must not be empty');
        }
        $validStatuses = ['CREATED', 'READY_TO_SHIP', 'SHIPPED', 'DELIVERED', 'CANCELLED'];
        foreach ($statuses as $status) {
            if (!in_array($status, $validStatuses, true)) {
                throw new InvalidArgumentException('Invalid status: ' . $status);
            }
        }
        if ($limit < 0 || $limit > 1000) {
            throw new InvalidArgumentException('Limit must be between 0 and 1000');
        }
        if ($offset < 0) {
            throw new InvalidArgumentException('Offset must be greater than or equal to 0');
        }
        $this->shippingGroupIds = array_unique($shippingGroupIds);
        $this->shipmentIds = array_unique($shipmentIds);
        $this->statuses = array_unique($statuses);
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Gets the shipping group IDs.
     *
     * @return array
     */
    public function getShippingGroupIds(): array
    {
        return $this->shippingGroupIds;
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
     * Gets the statuses.
     *
     * @return array
     */
    public function getStatuses(): array
    {
        return $this->statuses;
    }

    /**
     * Gets the limit.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Gets the offset.
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}