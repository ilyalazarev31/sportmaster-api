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
     */
    public function saveToken(string $token, int $expiresAt): void
    {
        $data = [
            'access_token' => $token,
            'expires_at' => $expiresAt,
        ];
        file_put_contents($this->filePath, json_encode($data));
    }

    /**
     * Retrieves the access token.
     *
     * @return string|null The access token or null if not found.
     */
    public function getToken(): ?string
    {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        return $data['access_token'] ?? null;
    }

    /**
     * Checks if the token has expired.
     *
     * @return bool True if the token is expired or not found, false otherwise.
     */
    public function isTokenExpired(): bool
    {
        if (!file_exists($this->filePath)) {
            return true;
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        $expiresAt = $data['expires_at'] ?? 0;
        return time() >= $expiresAt;
    }
}