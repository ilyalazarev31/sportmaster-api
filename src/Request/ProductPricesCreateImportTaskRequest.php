<?php

namespace Sportmaster\Api\Request;

/**
 * Request object for creating a product prices import task.
 */
class ProductPricesCreateImportTaskRequest
{
    private array $productPrices;

    /**
     * ProductPricesCreateImportTaskRequest constructor.
     *
     * @param PriceItem[] $productPrices Array of price items to import.
     * @throws \InvalidArgumentException If parameters are invalid.
     */
    public function __construct(array $productPrices)
    {
        if (empty($productPrices)) {
            throw new \InvalidArgumentException('productPrices cannot be empty');
        }
        if (count($productPrices) > 1000) {
            throw new \InvalidArgumentException('productPrices cannot exceed 1000 items');
        }
        $this->productPrices = $productPrices;
    }

    /**
     * Gets the array of price items.
     *
     * @return PriceItem[]
     */
    public function getProductPrices(): array
    {
        return $this->productPrices;
    }
}

/**
 * Represents a single price item for import.
 */
class PriceItem
{
    private string $offerId;
    private float $price;
    private ?float $discountPrice;

    /**
     * PriceItem constructor.
     *
     * @param string $offerId Product offer ID.
     * @param float $price Regular price.
     * @param float|null $discountPrice Discount price (optional).
     * @throws \InvalidArgumentException If offerId is invalid.
     */
    public function __construct(string $offerId, float $price, ?float $discountPrice = null)
    {
        if (!preg_match('/^[A-Za-zА-Яа-я0-9 #+*-./^_"]{1,50}$/', $offerId)) {
            throw new \InvalidArgumentException('Invalid offerId format: ' . $offerId);
        }
        $this->offerId = $offerId;
        $this->price = $price;
        $this->discountPrice = $discountPrice;
    }

    /**
     * Gets the offer ID.
     *
     * @return string
     */
    public function getOfferId(): string
    {
        return $this->offerId;
    }

    /**
     * Gets the regular price.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Gets the discount price.
     *
     * @return float|null
     */
    public function getDiscountPrice(): ?float
    {
        return $this->discountPrice;
    }
}