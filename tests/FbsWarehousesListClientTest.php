<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsWarehousesListClient;
use Sportmaster\Api\Request\FbsWarehousesListRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsWarehousesListClientTest extends TestCase
{
    public function testListWarehousesSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'items' => [
                    [
                        'id' => '16393450000',
                        'name' => 'Склад мой дом',
                        'address' => '127410, г. Москва, ул. Складская, д. 7',
                        'location' => ['latitude' => '55.864894', 'longitude' => '37.57784'],
                        'lagSelection' => 25,
                        'phone' => '79886435287',
                        'note' => 'Первый склад',
                        'workingWeekDays' => [
                            'monday' => true,
                            'tuesday' => true,
                            'wednesday' => true,
                            'thursday' => true,
                            'friday' => true,
                            'saturday' => false,
                            'sunday' => false,
                        ],
                        'noneWorkingDays' => ['2024-01-01', '2024-01-02'],
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
        $warehousesClient = new FbsWarehousesListClient($client);

        $request = new FbsWarehousesListRequest(20, 0);
        $response = $warehousesClient->list($request);

        $this->assertCount(1, $response->getWarehouses());
        $this->assertEquals('16393450000', $response->getWarehouses()[0]['id']);
        $this->assertEquals(20, $response->getLimit());
        $this->assertEquals(0, $response->getOffset());
        $this->assertEquals(1, $response->getTotal());
    }

    public function testListWarehousesInvalidRequest(): void
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
        $warehousesClient = new FbsWarehousesListClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $request = new FbsWarehousesListRequest(1001, -1);
        $warehousesClient->list($request);
    }
}