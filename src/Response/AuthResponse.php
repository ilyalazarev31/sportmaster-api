<?php

namespace Sportmaster\Api\Response;

use InvalidArgumentException;

/**
 * Response object for authentication with the Sportmaster Seller API.
 */
class AuthResponse
{
    private ?string $accessToken;
    private ?int $expiresIn;
    private ?string $tokenType;

    /**
     * AuthResponse constructor.
     *
     * @param string|null $accessToken Access token (JWT, ≤ 2000 characters).
     * @param int|null $expiresIn Token expiration time in seconds.
     * @param string|null $tokenType Token type (≤ 20 characters).
     * @throws \InvalidArgumentException If accessToken or tokenType length is invalid.
     */
    public function __construct(?string $accessToken, ?int $expiresIn, ?string $tokenType)
    {
        if ($accessToken !== null && strlen($accessToken) > 2000) {
            throw new InvalidArgumentException('Access token must be 2000 characters or less');
        }
        if ($tokenType !== null && strlen($tokenType) > 20) {
            throw new InvalidArgumentException('Token type must be 20 characters or less');
        }
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->tokenType = $tokenType;
    }

    /**
     * Gets the access token.
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Gets the token expiration time in seconds.
     *
     * @return int|null
     */
    public function getExpiresIn(): ?int
    {
        return $this->expiresIn;
    }

    /**
     * Gets the token type.
     *
     * @return string|null
     */
    public function getTokenType(): ?string
    {
        return $this->tokenType;
    }
}