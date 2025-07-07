<?php

namespace Sportmaster\Api\TokenStorage;

/**
 * Interface for token storage implementations.
 */
interface TokenStorageInterface
{
    /**
     * Saves the token and its expiration time.
     *
     * @param string $token The access token.
     * @param int $expiresAt Unix timestamp when the token expires.
     */
    public function saveToken(string $token, int $expiresAt): void;

    /**
     * Retrieves the stored token.
     *
     * @return string|null The access token or null if not found.
     */
    public function getToken(): ?string;

    /**
     * Checks if the token is expired.
     *
     * @return bool True if the token is expired or not found.
     */
    public function isTokenExpired(): bool;
}