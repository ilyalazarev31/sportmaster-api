<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for authentication with the Sportmaster Seller API.
 */
class AuthRequest
{
    private string $apiKey;

    /**
     * AuthRequest constructor.
     *
     * @param string $apiKey API key in UUID format.
     * @throws \InvalidArgumentException If apiKey is invalid.
     */
    public function __construct(string $apiKey)
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $apiKey)) {
            throw new InvalidArgumentException('Invalid apiKey format, must be a valid UUID');
        }
        $this->apiKey = $apiKey;
    }

    /**
     * Gets the API key.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}