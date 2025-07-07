<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesGetImportTaskByIdClient;
use Sportmaster\Api\Request\ProductPricesGetImportTaskByIdRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ProductPricesGetImportTaskByIdClientTest extends TestCase
{
    public function testGetImportTaskSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'taskId' => '100412',
                'statusDate' => '2024-04-03T13:02:13+03:00',
                'createDate' => '2024-04-03T13:00:00+03:00',
                'status' => 'LOADED',
                'productPrices' => [
                    [
                        'objectId' => '123456',
                        'offerId' => 'SM_ARticLE101',
                        'price' => 1200,
                        'retailPrice' => 999,
                        'currencyCode' => 'RUR',
                        'objectStatus' => 'LOADED',
                    ],
                ],
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
        $taskClient = new ProductPricesGetImportTaskByIdClient($client);

        $request = new ProductPricesGetImportTaskByIdRequest('100412');
        $response = $taskClient->get($request);

        $this->assertEquals('100412', $response->getTaskId());
        $this->assertEquals('LOADED', $response->getStatus());
        $this->assertCount(1, $response->getProductPrices());
    }

    public function testGetImportTaskInvalidRequest(): void
    {
        $mock = new MockHandler([
            new Response(400, [], json_encode([
                'errorMessage' => 'Invalid taskId',
                'errorCode' => 'BAD_REQUEST',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $taskClient = new ProductPricesGetImportTaskByIdClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid taskId');
        $this->expectExceptionCode(400);

        $request = new ProductPricesGetImportTaskByIdRequest('invalid_id');
        $taskClient->get($request);
    }

    public function testGetImportTaskUnauthorized(): void
    {
        $mock = new MockHandler([
            new Response(401, [], json_encode([
                'errorMessage' => 'Unauthorized',
                'errorCode' => 'UNAUTHORIZED',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $taskClient = new ProductPricesGetImportTaskByIdClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $request = new ProductPricesGetImportTaskByIdRequest('100412');
        $taskClient->get($request);
    }

    public function testGetImportTaskForbidden(): void
    {
        $mock = new MockHandler([
            new Response(403, [], json_encode([
                'errorMessage' => 'Forbidden',
                'errorCode' => 'FORBIDDEN',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $taskClient = new ProductPricesGetImportTaskByIdClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $request = new ProductPricesGetImportTaskByIdRequest('100412');
        $taskClient->get($request);
    }

    public function testGetImportTaskTooManyRequests(): void
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
        $taskClient = new ProductPricesGetImportTaskByIdClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $request = new ProductPricesGetImportTaskByIdRequest('100412');
        $taskClient->get($request);
    }

    public function testGetImportTaskServerError(): void
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
        $taskClient = new ProductPricesGetImportTaskByIdClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $request = new ProductPricesGetImportTaskByIdRequest('100412');
        $taskClient->get($request);
    }
}