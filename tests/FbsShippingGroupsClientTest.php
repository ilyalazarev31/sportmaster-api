<?php

namespace Sportmaster\Api\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShippingGroupsClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShippingGroupsRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShippingGroupsClientTest extends TestCase
{
    public function testCreateShippingGroupSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'shippingGroupId' => '12376390',
                'shipmentIds' => ['16393450000', '16393450001'],
                'courierCompanyId' => '12376390',
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
        $shippingGroupsClient = new FbsShippingGroupsClient($client);

        $request = new FbsShippingGroupsRequest(['16393450000', '16393450001'], '12376390');

        try {
            $response = $shippingGroupsClient->create($request);
        } catch (ApiException $e) {
        }

        $this->assertEquals('12376390', $response->getShippingGroupId());
        $this->assertEquals(['16393450000', '16393450001'], $response->getShipmentIds());
        $this->assertEquals('12376390', $response->getCourierCompanyId());
    }

    public function testCreateShippingGroupInvalidRequest(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shippingGroupsClient = new FbsShippingGroupsClient($client);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Shipment IDs array must not be empty');

        new FbsShippingGroupsRequest([], '12376390');
    }
}