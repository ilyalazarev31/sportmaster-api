<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesListClient;
use Sportmaster\Api\Request\ProductPricesListRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ProductPricesListClientTest extends TestCase
{
    public function testListPricesSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'productPrices' => [
                    [
                        'offerId' => 'EIFJM1VRHE',
                        'price' => 1500,
                        'retailPrice' => 999,
                        'currencyCode' => 'RUR',
                    ],
                ],
                'pagination' => ['limit' => 20, 'offset' => 0, 'total' => 1],
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
        $pricesClient = new ProductPricesListClient($client);

        $request = new ProductPricesListRequest(['EIFJM1VRHE'], 20, 0);
        $response = $pricesClient->list($request);

        $this->assertCount(1, $response->getProductPrices());
        $this->assertEquals('EIFJM1VRHE', $response->getProductPrices()[0]['offerId']);
        $this->assertEquals(20, $response->getLimit());
        $this->assertEquals(0, $response->getOffset());
        $this->assertEquals(1, $response->getTotal());
    }

    public function testListPricesInvalidRequest(): void
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
        $pricesClient = new ProductPricesListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $request = new ProductPricesListRequest(['invalid@offer'], 20, 0);
        $pricesClient->list($request);
    }

    public function testListPricesUnauthorized(): void
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
        $pricesClient = new ProductPricesListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $request = new ProductPricesListRequest(['EIFJM1VRHE'], 20, 0);
        $pricesClient->list($request);
    }

    public function testListPricesForbidden(): void
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
        $pricesClient = new ProductPricesListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $request = new ProductPricesListRequest(['EIFJM1VRHE'], 20, 0);
        $pricesClient->list($request);
    }

    public function testListPricesTooManyRequests(): void
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
        $pricesClient = new ProductPricesListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $request = new ProductPricesListRequest(['EIFJM1VRHE'], 20, 0);
        $pricesClient->list($request);
    }

    public function testListPricesServerError(): void
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
        $pricesClient = new ProductPricesListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $request = new ProductPricesListRequest(['EIFJM1VRHE'], 20, 0);
        $pricesClient->list($request);
    }
}