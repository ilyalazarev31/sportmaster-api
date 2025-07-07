<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesListClient;
use Sportmaster\Api\Endpoints\ProductPricesCreateImportTaskClient;
use Sportmaster\Api\Endpoints\ProductPricesGetImportTaskByIdClient;
use Sportmaster\Api\Request\ProductPricesListRequest;
use Sportmaster\Api\Request\ProductPricesCreateImportTaskRequest;
use Sportmaster\Api\Request\ProductPricesGetImportTaskByIdRequest;
use Sportmaster\Api\Request\PriceItem;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ProductPricesClientsTest extends TestCase
{
    public function testListPricesSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'productPrices' => [
                    ['offerId' => 'T4P00911MDAW', 'price' => 99.99],
                    ['offerId' => 'BNN01821MEOW', 'price' => 149.99],
                ],
                'pagination' => ['limit' => 100, 'offset' => 0, 'total' => 2],
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

        $request = new ProductPricesListRequest(['T4P00911MDAW', 'BNN01821MEOW'], 100, 0);
        $response = $pricesClient->list($request);

        $this->assertCount(2, $response->getProductPrices());
        $this->assertEquals('T4P00911MDAW', $response->getProductPrices()[0]['offerId']);
        $this->assertEquals(2, $response->getPagination()['total']);
    }

    public function testCreateImportTaskSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['taskId' => '1245212'])),
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

        $prices = [new PriceItem('T4P00911MDAW', 99.99)];
        $request = new ProductPricesCreateImportTaskRequest($prices);
        $response = $importClient->create($request);

        $this->assertEquals('1245212', $response->getTaskId());
    }

    public function testGetImportTaskByIdSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'taskId' => '1245212',
                'status' => 'completed',
                'createdAt' => '2023-10-01T12:00:00Z',
                'updatedAt' => '2023-10-01T12:05:00Z',
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

        $request = new ProductPricesGetImportTaskByIdRequest('1245212');
        $response = $taskClient->get($request);

        $this->assertEquals('1245212', $response->getTaskId());
        $this->assertEquals('completed', $response->getStatus());
    }
}