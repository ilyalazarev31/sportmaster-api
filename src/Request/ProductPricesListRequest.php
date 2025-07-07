<?php
namespace Sportmaster\Api\Request;
/**
 * Request object for listing product prices.
 */
class ProductPricesListRequest
{
    private ?array $offerIds;
    private ?int $limit;
    private ?int $offset;
    /**
     * ProductPricesListRequest constructor.
     *
     * @param array|null $offerIds List of product offer IDs (max 1000, optional).
     * @param int|null $limit Maximum number of items in response (0-1000, default: 20).
     * @param int|null $offset Offset for pagination (default: 0).
     * @throws \InvalidArgumentException If parameters are invalid.
     */
    public function __construct(?array $offerIds = null, ?int $limit = 20, ?int $offset = 0)
    {
        if ($offerIds !== null && count($offerIds) > 1000) {
            throw new \InvalidArgumentException('offerIds cannot exceed 1000 items');
        }
        if ($offerIds !== null) {
            foreach ($offerIds as $offerId) {
                if (!preg_match('/^[A-Za-zА-Яа-я0-9 #+*-./^_"]{1,50}$/', $offerId)) {
                    throw new \InvalidArgumentException('Invalid offerId format: ' . $offerId);
                }
            }
        }
        if ($limit !== null && ($limit < 0 || $limit > 1000)) {
            throw new \InvalidArgumentException('Limit must be between 0 and 1000');
        }
        if ($offset !== null && $offset < 0) {
            throw new \InvalidArgumentException('Offset must be non-negative');
        }
        $this->offerIds = $offerIds;
        $this->limit = $limit;
        $this->offset = $offset;
    }
    /**
     * Gets the list of offer IDs.
     *
     * @return array|null
     */
    public function getOfferIds(): ?array
    {
        return $this->offerIds;
    }
    /**
     * Gets the limit.
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }
    /**
     * Gets the offset.
     *
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }
}