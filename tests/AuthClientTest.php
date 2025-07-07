<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\AuthClient;
use Sportmaster\Api\Request\AuthRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class AuthClientTest extends TestCase
{
    public function testAuthenticateSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'accessToken' => 'jwt_token_123',
                'expiresIn' => 3600,
                'tokenType' => 'Bearer',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn('test_token');
        $tokenStorage->method('isTokenExpired')->willReturn(false);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $authClient = new AuthClient($client);

        $request = new AuthRequest('550e8400-e29b-41d4-a716-446655440000');
        $response = $authClient->authenticate($request);

        $this->assertEquals('jwt_token_123', $response->getAccessToken());
        $this->assertEquals(3600, $response->getExpiresIn());
        $this->assertEquals('Bearer', $response->getTokenType());
    }

    public function testAuthenticateInvalidApiKey(): void
    {
        $mock = new MockHandler([
            new Response(400, [], json_encode([
                'errorMessage' => 'Invalid API key',
                'errorCode' => 'BAD_REQUEST',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $authClient = new AuthClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid API key');
        $this->expectExceptionCode(400);

        $request = new AuthRequest('invalid-uuid');
        $authClient->authenticate($request);
    }

    public function testAuthenticateTooManyRequests(): void
    {
        $mock = new MockHandler([
            new Response(429, [], json_encode([
                'errorMessage' => 'Too many requests',
                'errorCode' => 'TOO_MANY_REQUESTS',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $authClient = new AuthClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $request = new AuthRequest('550e8400-e29b-41d4-a716-446655440000');
        $authClient->authenticate($request);
    }

    public function testAuthenticateServerError(): void
    {
        $mock = new MockHandler([
            new Response(500, [], json_encode([
                'errorMessage' => 'Internal server error',
                'errorCode' => 'INTERNAL_SERVER_ERROR',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $authClient = new AuthClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $request = new AuthRequest('550e8400-e29b-41d4-a716-446655440000');
        $authClient->authenticate($request);
    }
}