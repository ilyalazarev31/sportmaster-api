<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsStocksCreateImportTaskClient;
use Sportmaster\Api\Request\FbsStocksCreateImportTaskRequest;
use Sportmaster\Api\Request\StockItem;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsStocksCreateImportTaskClientTest extends TestCase
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
        $importClient = new FbsStocksCreateImportTaskClient($client);

        $stocks = [
            new StockItem('EIFJM1VRHE', 10),
            new StockItem('M04IPXX5KS', 20),
        ];
        $request = new FbsStocksCreateImportTaskRequest('32660299', $stocks);
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
        $importClient = new FbsStocksCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $stocks = [];
        $request = new FbsStocksCreateImportTaskRequest('32660299', $stocks);
        $importClient->create($request);
    }
}