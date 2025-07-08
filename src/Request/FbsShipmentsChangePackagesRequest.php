<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for changing packages for a specific FBS shipment.
 */
class FbsShipmentsChangePackagesRequest
{
    private array $packages;

    /**
     * FbsShipmentsChangePackagesRequest constructor.
     *
     * @param array $packages Array of package details (non-empty, max 1000).
     * @throws \InvalidArgumentException If packages array is invalid.
     */
    public function __construct(array $packages)
    {
        if (empty($packages)) {
            throw new InvalidArgumentException('Packages array must not be empty');
        }
        if (count($packages) > 1000) {
            throw new InvalidArgumentException('Packages array must not exceed 1000 items');
        }
        foreach ($packages as $package) {
            if (!isset($package['exemplarIds']) || !is_array($package['exemplarIds']) || empty($package['exemplarIds'])) {
                throw new InvalidArgumentException('Each package must have a non-empty exemplarIds array');
            }
            foreach ($package['exemplarIds'] as $exemplarId) {
                if (!is_string($exemplarId) || !preg_match('/^\d{1,20}$/', $exemplarId)) {
                    throw new InvalidArgumentException('Each exemplarId must be a string of 1–20 digits');
                }
            }
        }
        $this->packages = $packages;
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
}