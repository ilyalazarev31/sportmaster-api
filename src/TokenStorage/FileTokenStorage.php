<?php

namespace Sportmaster\Api\TokenStorage;

/**
 * File-based token storage implementation.
 */
class FileTokenStorage implements TokenStorageInterface
{
    private string $filePath;

    /**
     * FileTokenStorage constructor.
     *
     * @param string $filePath Path to the token storage file.
     */
    public function __construct(string $filePath = '.sportmaster_token.json')
    {
        $this->filePath = $filePath;
    }

    /**
     * Saves the access token and its expiration time.
     *
     * @param string $token Access token.
     * @param int $expiresAt Unix timestamp when the token expires.
     * @throws \JsonException
     */
    public function saveToken(string $token, int $expiresAt): void
    {
        $data = [
            'access_token' => $token,
            'expires_at' => $expiresAt,
        ];
        file_put_contents($this->filePath, json_encode($data, JSON_THROW_ON_ERROR));
    }

    /**
     * Retrieves the access token.
     *
     * @return string|null The access token or null if not found.
     * @throws \JsonException
     */
    public function getToken(): ?string
    {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $data = json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR);
        return $data['access_token'] ?? null;
    }

    /**
     * Checks if the token has expired.
     *
     * @return bool True if the token is expired or not found, false otherwise.
     * @throws \JsonException
     */
    public function isTokenExpired(): bool
    {
        if (!file_exists($this->filePath)) {
            return true;
        }
        $data = json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR);
        $expiresAt = $data['expires_at'] ?? 0;
        return time() >= $expiresAt;
    }
}