<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsSetExemplarMandatoryMarkClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShipmentsSetExemplarMandatoryMarkRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShipmentsSetExemplarMandatoryMarkClientTest extends TestCase
{
    public function testSetExemplarMandatoryMarkSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'isMandatoryMarkSet' => false,
                'verificationErrors' => [
                    [
                        'code' => 'MANADATORY_MARK_DOES_NOT_MATCH_GTIN',
                        'description' => 'Код маркировки не соответствует GTIN',
                        'isBlocking' => true,
                    ],
                ],
            ], JSON_THROW_ON_ERROR)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        try {
            $tokenStorage = $this->createMock(TokenStorageInterface::class);
        } catch (Exception $e) {
        }
        $tokenStorage->method('getToken')->willReturn('test_token');
        $tokenStorage->method('isTokenExpired')->willReturn(false);
        try {
            $logger = $this->createMock(LoggerInterface::class);
        } catch (Exception $e) {
        }

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            '12376390',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        try {
            $response = $markClient->setExemplarMandatoryMark('16393450000', $request);
        } catch (ApiException $e) {
        }

        $this->assertFalse($response->isMandatoryMarkSet());
        $this->assertCount(1, $response->getVerificationErrors());
    }

    public function testSetExemplarMandatoryMarkInvalidShipmentId(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            '12376390',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid shipmentId format, must be 1–14 digits');
        $this->expectExceptionCode(400);

        $markClient->setExemplarMandatoryMark('invalid_id', $request);
    }

    public function testSetExemplarMandatoryMarkInvalidRequest(): void
    {
        $mock = new MockHandler([
            new Response(400, [], json_encode([
                'errorMessage' => 'Invalid request parameters',
                'errorCode' => 'BAD_REQUEST',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        try {
            $tokenStorage = $this->createMock(TokenStorageInterface::class);
        } catch (Exception $e) {
        }
        try {
            $logger = $this->createMock(LoggerInterface::class);
        } catch (Exception $e) {
        }

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            'invalid_id',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        $markClient->setExemplarMandatoryMark('16393450000', $request);
    }

    public function testSetExemplarMandatoryMarkUnauthorized(): void
    {
        $mock = new MockHandler([
            new Response(401, [], json_encode([
                'errorMessage' => 'Unauthorized',
                'errorCode' => 'UNAUTHORIZED',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        try {
            $tokenStorage = $this->createMock(TokenStorageInterface::class);
        } catch (Exception $e) {
        }
        try {
            $logger = $this->createMock(LoggerInterface::class);
        } catch (Exception $e) {
        }

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            '12376390',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        $markClient->setExemplarMandatoryMark('16393450000', $request);
    }

    public function testSetExemplarMandatoryMarkForbidden(): void
    {
        $mock = new MockHandler([
            new Response(403, [], json_encode([
                'errorMessage' => 'Forbidden',
                'errorCode' => 'FORBIDDEN',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        try {
            $tokenStorage = $this->createMock(TokenStorageInterface::class);
        } catch (Exception $e) {
        }
        try {
            $logger = $this->createMock(LoggerInterface::class);
        } catch (Exception $e) {
        }

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            '12376390',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        $markClient->setExemplarMandatoryMark('16393450000', $request);
    }

    public function testSetExemplarMandatoryMarkTooManyRequests(): void
    {
        $mock = new MockHandler([
            new Response(429, [], json_encode([
                'errorMessage' => 'Too many requests',
                'errorCode' => 'TOO_MANY_REQUESTS',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        try {
            $tokenStorage = $this->createMock(TokenStorageInterface::class);
        } catch (Exception $e) {
        }
        try {
            $logger = $this->createMock(LoggerInterface::class);
        } catch (Exception $e) {
        }

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            '12376390',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        $markClient->setExemplarMandatoryMark('16393450000', $request);
    }

    public function testSetExemplarMandatoryMarkServerError(): void
    {
        $mock = new MockHandler([
            new Response(500, [], json_encode([
                'errorMessage' => 'Internal server error',
                'errorCode' => 'INTERNAL_SERVER_ERROR',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        try {
            $tokenStorage = $this->createMock(TokenStorageInterface::class);
        } catch (Exception $e) {
        }
        try {
            $logger = $this->createMock(LoggerInterface::class);
        } catch (Exception $e) {
        }

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
            '12376390',
            '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
        );

        $markClient->setExemplarMandatoryMark('16393450000', $request);
    }
}