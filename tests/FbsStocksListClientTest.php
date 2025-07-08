<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsStocksListClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsStocksListRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsStocksListClientTest extends TestCase
{
    public function testListStocksSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'stocks' => [
                    [
                        'offerId' => 'EIFJM1VRHE',
                        'barcode' => '4660182105588',
                        'name' => 'Ботинки лыжные SPINE Concept Skate 296-22 NNN',
                        'warehouseStock' => 10,
                        'retailStock' => 2,
                        'errors' => [
                            [
                                'code' => 'PRODUCT_DIMENSIONS_LIMITS_EXCEEDED_FOR_DELIVERY',
                                'description' => 'Превышен лимит объёма товара для доставки',
                            ],
                        ],
                    ],
                ],
                'pagination' => ['limit' => 20, 'offset' => 0, 'total' => 1],
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
        $stocksClient = new FbsStocksListClient($client);

        $request = new FbsStocksListRequest('32660299', 20, 0);
        try {
            $response = $stocksClient->list($request);
        } catch (ApiException $e) {
        }

        $this->assertCount(1, $response->getStocks());
        $this->assertEquals('EIFJM1VRHE', $response->getStocks()[0]['offerId']);
        $this->assertEquals(20, $response->getLimit());
        $this->assertEquals(0, $response->getOffset());
        $this->assertEquals(1, $response->getTotal());
    }

    public function testListStocksInvalidWarehouseId(): void
    {
        $mock = new MockHandler([
            new Response(400, [], json_encode([
                'errorMessage' => 'Invalid warehouseId',
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
        $stocksClient = new FbsStocksListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid warehouseId');
        $this->expectExceptionCode(400);

        $request = new FbsStocksListRequest('invalid_id', 20, 0);
        $stocksClient->list($request);
    }
}