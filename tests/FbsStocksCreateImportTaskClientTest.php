<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsStocksCreateImportTaskClient;
use Sportmaster\Api\Exception\ApiException;
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
        $importClient = new FbsStocksCreateImportTaskClient($client);

        $stocks = [
            new StockItem('EIFJM1VRHE', 10),
            new StockItem('M04IPXX5KS', 20),
        ];
        $request = new FbsStocksCreateImportTaskRequest('32660299', $stocks);
        try {
            $response = $importClient->create($request);
        } catch (ApiException $e) {
        }

        $this->assertEquals('1245212', $response->getTaskId());
    }

    public function testCreateImportTaskInvalidRequest(): void
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
        $importClient = new FbsStocksCreateImportTaskClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $stocks = [];
        $request = new FbsStocksCreateImportTaskRequest('32660299', $stocks);
        $importClient->create($request);
    }
}