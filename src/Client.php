<?php

namespace Sportmaster\Api;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Endpoints\AuthClient;
use Sportmaster\Api\Request\AuthRequest;
use Sportmaster\Api\Exception\ApiException;

/**
 * Main API client for interacting with the Sportmaster Seller API.
 */
class Client
{
    private ClientInterface $httpClient;
    private TokenStorageInterface $tokenStorage;
    private LoggerInterface $logger;
    private string $baseUri;
    private ?AuthClient $authClient = null;
    private ?AuthRequest $authRequest = null;
    private ?string $clientId = null;

    /**
     * Client constructor.
     *
     * @param ClientInterface|null $httpClient HTTP client implementation (defaults to Guzzle).
     * @param \Sportmaster\Api\TokenStorage\TokenStorageInterface|null $tokenStorage Token storage implementation.
     * @param \Psr\Log\LoggerInterface|null $logger Logger implementation.
     * @param string $baseUri Base URI for the API (e.g., 'https://api-seller.sportmaster.ru').
     */
    public function __construct(
        ?ClientInterface $httpClient = null,
        ?TokenStorageInterface $tokenStorage = null,
        ?LoggerInterface $logger = null,
        string $baseUri = 'https://api-seller.sportmaster.ru'
    ) {
        $this->httpClient = $httpClient ?? new GuzzleClient();
        $this->tokenStorage = $tokenStorage ?? new TokenStorage\FileTokenStorage();
        $this->logger = $logger ?? new Logger\FileLogger();
        $this->baseUri = rtrim($baseUri, '/');
    }

    /**
     * Sets the authentication request for token refresh.
     *
     * @param AuthRequest $authRequest Authentication request object.
     */
    public function setAuthRequest(AuthRequest $authRequest): void
    {
        $this->authRequest = $authRequest;
        $this->authClient = new AuthClient($this);
    }

    /**
     * Sets the Client-ID for API requests.
     *
     * @param string $clientId Client ID.
     * @throws \InvalidArgumentException If Client-ID format is invalid.
     */
    public function setClientId(string $clientId): void
    {
        if (!preg_match('/^\d{1,20}$/', $clientId)) {
            throw new InvalidArgumentException('Invalid Client-ID format: ' . $clientId);
        }
        $this->clientId = $clientId;
    }

    /**
     * Sends an HTTP request with authorization header.
     *
     * @param string $method HTTP method (GET, POST, etc.).
     * @param string $endpoint API endpoint (e.g., '/api/auth/token').
     * @param array $data Request data.
     * @return array Response data.
     * @throws ApiException If the request fails or token is invalid.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        if ($endpoint !== '/api/auth/token' && $this->tokenStorage->isTokenExpired() && $this->authRequest && $this->authClient) {
            $this->logger->info("Token expired, refreshing...");
            $response = $this->authClient->authenticate($this->authRequest);
            $this->tokenStorage->saveToken($response->getAccessToken(), time() + $response->getExpiresIn());
        }

        try {
            $headers = [
                'Content-Type' => 'application/json',
            ];

            if ($endpoint !== '/api/auth/token') {
                $headers['Authorization'] = 'Bearer ' . $this->tokenStorage->getToken();
            }

            if ($this->clientId) {
                $headers['Client-ID'] = $this->clientId;
            }

            $options = ['headers' => $headers];
            if (!empty($data)) {
                $options['json'] = $data;
            }

            $response = $this->httpClient->request($method, $this->baseUri . $endpoint, $options);

            $this->logger->info("Request successful: {$method} {$endpoint}");

            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (RequestException|GuzzleException $e) {
            $this->logger->error("Request failed: {$method} {$endpoint}, Error: {$e->getMessage()}");
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
                $errorCode = $response['errorCode'] ?? 'UNKNOWN';
                $errorMessage = $response['errorMessage'] ?? $e->getMessage();
                throw new ApiException($errorMessage, $e->getResponse()->getStatusCode(), $errorCode);
            }
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Gets the token storage instance.
     *
     * @return TokenStorageInterface
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->tokenStorage;
    }

    /**
     * Gets the logger instance.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}