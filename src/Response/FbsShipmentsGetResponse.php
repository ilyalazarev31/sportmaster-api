<?php

namespace Sportmaster\Api\Response;

use InvalidArgumentException;

/**
 * Response object for retrieving detailed information about an FBS shipment.
 */
class FbsShipmentsGetResponse
{
    private ?string $id;
    private ?string $status;
    private ?string $orderNumber;
    private ?string $createDate;
    private ?string $planedDate;
    private ?string $lastStatusDate;
    private array $warehouse;
    private array $dropOffPoint;
    private array $courierCompany;
    private array $totalCost;
    private array $shippingGroup;
    private array $orderStatus;
    private ?string $shippingMethod;
    private bool $isMultiPackage;
    private array $packages;
    private array $rejectedProducts;

    /**
     * FbsShipmentsGetResponse constructor.
     *
     * @param string|null $id Shipment ID.
     * @param string|null $status Shipment status.
     * @param string|null $orderNumber Order number.
     * @param string|null $createDate Creation date (ISO 8601).
     * @param string|null $planedDate Planned date (ISO 8601).
     * @param string|null $lastStatusDate Last status update date (ISO 8601).
     * @param array $warehouse Warehouse details.
     * @param array $dropOffPoint Drop-off point details.
     * @param array $courierCompany Courier company details.
     * @param array $totalCost Total cost details.
     * @param array $shippingGroup Shipping group details.
     * @param array $orderStatus Order status details.
     * @param string|null $shippingMethod Shipping method.
     * @param bool $isMultiPackage Whether the shipment has multiple packages.
     * @param array $packages Package details.
     * @param array $rejectedProducts Rejected product details.
     * @throws \InvalidArgumentException If date formats are invalid.
     */
    public function __construct(
        ?string $id,
        ?string $status,
        ?string $orderNumber,
        ?string $createDate,
        ?string $planedDate,
        ?string $lastStatusDate,
        array $warehouse,
        array $dropOffPoint,
        array $courierCompany,
        array $totalCost,
        array $shippingGroup,
        array $orderStatus,
        ?string $shippingMethod,
        bool $isMultiPackage,
        array $packages,
        array $rejectedProducts
    ) {
        if ($createDate !== null && !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+-]\d{2}:\d{2}|Z)$/', $createDate)) {
            throw new InvalidArgumentException('Invalid createDate format, must be ISO 8601');
        }
        if ($planedDate !== null && !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+-]\d{2}:\d{2}|Z)$/', $planedDate)) {
            throw new InvalidArgumentException('Invalid planedDate format, must be ISO 8601');
        }
        if ($lastStatusDate !== null && !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+-]\d{2}:\d{2}|Z)$/', $lastStatusDate)) {
            throw new InvalidArgumentException('Invalid lastStatusDate format, must be ISO 8601');
        }
        $this->id = $id;
        $this->status = $status;
        $this->orderNumber = $orderNumber;
        $this->createDate = $createDate;
        $this->planedDate = $planedDate;
        $this->lastStatusDate = $lastStatusDate;
        $this->warehouse = $warehouse;
        $this->dropOffPoint = $dropOffPoint;
        $this->courierCompany = $courierCompany;
        $this->totalCost = $totalCost;
        $this->shippingGroup = $shippingGroup;
        $this->orderStatus = $orderStatus;
        $this->shippingMethod = $shippingMethod;
        $this->isMultiPackage = $isMultiPackage;
        $this->packages = $packages;
        $this->rejectedProducts = $rejectedProducts;
    }

    /**
     * Gets the shipment ID.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Gets the shipment status.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Gets the order number.
     *
     * @return string|null
     */
    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    /**
     * Gets the creation date.
     *
     * @return string|null
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Gets the planned date.
     *
     * @return string|null
     */
    public function getPlanedDate(): ?string
    {
        return $this->planedDate;
    }

    /**
     * Gets the last status update date.
     *
     * @return string|null
     */
    public function getLastStatusDate(): ?string
    {
        return $this->lastStatusDate;
    }

    /**
     * Gets the warehouse details.
     *
     * @return array
     */
    public function getWarehouse(): array
    {
        return $this->warehouse;
    }

    /**
     * Gets the drop-off point details.
     *
     * @return array
     */
    public function getDropOffPoint(): array
    {
        return $this->dropOffPoint;
    }

    /**
     * Gets the courier company details.
     *
     * @return array
     */
    public function getCourierCompany(): array
    {
        return $this->courierCompany;
    }

    /**
     * Gets the total cost details.
     *
     * @return array
     */
    public function getTotalCost(): array
    {
        return $this->totalCost;
    }

    /**
     * Gets the shipping group details.
     *
     * @return array
     */
    public function getShippingGroup(): array
    {
        return $this->shippingGroup;
    }

    /**
     * Gets the order status details.
     *
     * @return array
     */
    public function getOrderStatus(): array
    {
        return $this->orderStatus;
    }

    /**
     * Gets the shipping method.
     *
     * @return string|null
     */
    public function getShippingMethod(): ?string
    {
        return $this->shippingMethod;
    }

    /**
     * Checks if the shipment has multiple packages.
     *
     * @return bool
     */
    public function isMultiPackage(): bool
    {
        return $this->isMultiPackage;
    }

    /**
     * Gets the package details.
     *
     * @return array
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * Gets the rejected product details.
     *
     * @return array
     */
    public function getRejectedProducts(): array
    {
        return $this->rejectedProducts;
    }
}