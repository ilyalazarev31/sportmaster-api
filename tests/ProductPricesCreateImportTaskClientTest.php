<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesCreateImportTaskClient;
use Sportmaster\Api\Request\ProductPricesCreateImportTaskRequest;
use Sportmaster\Api\Request\PriceItem;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ProductPricesCreateImportTaskClientTest extends TestCase
{
    public function testCreateImportTaskSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'taskId' => '1245212',
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
        $importClient = new ProductPricesCreateImportTaskClient($client);

        $prices = [
            new PriceItem('EIFJM1VRHE', 1500, 999),
            new PriceItem('M04IPXX5KS', 600),
        ];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $response = $importClient->create($request);

        $this->assertEquals('1245212', $response->getTaskId());
    }

    public function testCreateImportTaskInvalidRequest(): void
    {
        $mock = new MockHandler([
            new Response(400, [], json_encode([
                'errorMessage' => 'Invalid request parameters',
                'errorCode' => 'BAD_REQUEST',
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleClient(['handler' => $handlerStack]);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $client = new Client($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $importClient = new ProductPricesCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $prices = [];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $importClient->create($request);
    }

    public function testCreateImportTaskUnauthorized(): void
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
        $importClient = new ProductPricesCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $prices = [new PriceItem('EIFJM1VRHE', 1500, 999)];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $importClient->create($request);
    }

    public function testCreateImportTaskForbidden(): void
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
        $importClient = new ProductPricesCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $prices = [new PriceItem('EIFJM1VRHE', 1500, 999)];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $importClient->create($request);
    }

    public function testCreateImportTaskTooManyRequests(): void
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
        $importClient = new ProductPricesCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $prices = [new PriceItem('EIFJM1VRHE', 1500, 999)];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $importClient->create($request);
    }

    public function testCreateImportTaskServerError(): void
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
        $importClient = new ProductPricesCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $prices = [new PriceItem('EIFJM1VRHE', 1500, 999)];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $importClient->create($request);
    }
}