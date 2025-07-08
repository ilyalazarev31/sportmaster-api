<?php

namespace Sportmaster\Api\Endpoints;

use Sportmaster\Api\Client;
use Sportmaster\Api\Request\AuthRequest;
use Sportmaster\Api\Response\AuthResponse;
use Sportmaster\Api\Exception\ApiException;

/**
 * Client for handling authentication with the Sportmaster Seller API.
 */
class AuthClient
{
    private Client $client;

    /**
     * AuthClient constructor.
     *
     * @param Client $client The main API client.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticates and retrieves an access token.
     *
     * @param AuthRequest $request Authentication request with API key.
     * @return AuthResponse Response containing access token, expiration, and token type.
     * @throws \JsonException
     * @throws \Sportmaster\Api\Exception\ApiException If the authentication request fails.
     */
    public function authenticate(AuthRequest $request): AuthResponse
    {
        try {
            $data = [
                'apiKey' => $request->getApiKey(),
            ];

            $response = $this->client->request('POST', '/api/auth/token', $data);

            return new AuthResponse(
                $response['accessToken'] ?? null,
                $response['expiresIn'] ?? null,
                $response['tokenType'] ?? null
            );
        } catch (ApiException $e) {
            $this->client->getLogger()->error("Authentication failed: {$e->getMessage()}, Code: {$e->getErrorCode()}");
            throw $e;
        }
    }
}