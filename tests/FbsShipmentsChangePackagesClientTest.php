<?php

namespace Sportmaster\Api\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsChangePackagesClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShipmentsChangePackagesRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShipmentsChangePackagesClientTest extends TestCase
{
    public function testChangePackagesSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'shipmentId' => '16393450000',
                'packages' => [
                    [
                        'exemplarIds' => ['2389472891', '2389472892'],
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
        $shipmentsClient = new FbsShipmentsChangePackagesClient($client);

        $request = new FbsShipmentsChangePackagesRequest([
            [
                'exemplarIds' => ['2389472891', '2389472892'],
            ],
        ]);

        try {
            $response = $shipmentsClient->changePackages('16393450000', $request);
        } catch (ApiException $e) {
        }

        $this->assertEquals('16393450000', $response->getShipmentId());
        $this->assertCount(1, $response->getPackages());
        $this->assertEquals(['2389472891', '2389472892'], $response->getPackages()[0]['exemplarIds']);
    }

    public function testChangePackagesInvalidShipmentId(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shipmentsClient = new FbsShipmentsChangePackagesClient($client);

        $request = new FbsShipmentsChangePackagesRequest([
            [
                'exemplarIds' => ['2389472891'],
            ],
        ]);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid shipmentId format, must be 1–20 digits');
        $this->expectExceptionCode(400);

        $shipmentsClient->changePackages('invalid_id', $request);
    }

    public function testChangePackagesInvalidRequest(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shipmentsClient = new FbsShipmentsChangePackagesClient($client);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Packages array must not be empty');

        new FbsShipmentsChangePackagesRequest([]);
    }
}