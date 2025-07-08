<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsGetClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShipmentsGetClientTest extends TestCase
{
    public function testGetShipmentSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'id' => '16393450000',
                'status' => 'FOR_PICKING',
                'orderNumber' => '2707221-937804',
                'createDate' => '2025-03-24T18:40:44+03:00',
                'planedDate' => '2025-04-10T18:40:44+03:00',
                'lastStatusDate' => '2025-03-28T08:40:44+03:00',
                'warehouse' => [
                    'id' => '12376390',
                    'name' => 'Склад мой дом',
                    'address' => '127410, г. Москва, ул. Складская, д. 7',
                    'isClosed' => false,
                ],
                'dropOffPoint' => [
                    'id' => '12376390',
                    'name' => 'ОПС 48472',
                    'type' => 'Сортировочный центр',
                    'address' => '127410, г. Москва, ул. Приемная, д. 7',
                ],
                'courierCompany' => [
                    'id' => '12376390',
                    'name' => 'ООО «Быстрые Колеса»',
                ],
                'totalCost' => [
                    'amount' => 6849.99,
                    'currencyCode' => 'RUB',
                ],
                'shippingGroup' => [
                    'id' => '12376390',
                    'status' => 'READY_TO_SHIP',
                    'shippingGroupNumber' => '3163',
                    'batchNumInCC' => '9001454',
                ],
                'orderStatus' => [
                    'name' => 'Поступил в ПВЗ',
                    'status' => 'ARRIVED_TO_PICKUP_POINT',
                ],
                'shippingMethod' => 'DROP-OFF',
                'isMultiPackage' => true,
                'packages' => [
                    [
                        'id' => '12376390',
                        'barcode' => '80086180166400',
                        'weightAndSizeCharacteristics' => [
                            'weight' => 54.34,
                            'height' => 60,
                            'length' => 24,
                            'width' => 49,
                        ],
                        'packageProducts' => [
                            [
                                'name' => 'Куртка дутая',
                                'offerId' => 'SM_ARticLE101',
                                'isMandatoryMarkRequired' => true,
                                'quantity' => 2,
                                'exemplars' => [
                                    [
                                        'id' => '2389472891',
                                        'status' => 'FOR_PICKING',
                                        'mandatoryMark' => '0171356187643355215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg==',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'rejectedProducts' => [],
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
        $shipmentsClient = new FbsShipmentsGetClient($client);

        try {
            $response = $shipmentsClient->get('16393450000');
        } catch (ApiException $e) {
        }

        $this->assertEquals('16393450000', $response->getId());
        $this->assertEquals('FOR_PICKING', $response->getStatus());
        $this->assertEquals('2707221-937804', $response->getOrderNumber());
        $this->assertCount(1, $response->getPackages());
    }

    public function testGetShipmentInvalidId(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shipmentsClient = new FbsShipmentsGetClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid shipmentId format, must be 1–14 digits');
        $this->expectExceptionCode(400);

        $shipmentsClient->get('invalid_id');
    }

    public function testGetShipmentUnauthorized(): void
    {
        $mock = new MockHandler([
            new Response(401, [], json_encode([
                'errorMessage' => 'Unauthorized',
                'errorCode' => 'UNAUTHORIZED',
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
        $shipmentsClient = new FbsShipmentsGetClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $shipmentsClient->get('16393450000');
    }

    public function testGetShipmentForbidden(): void
    {
        $mock = new MockHandler([
            new Response(403, [], json_encode([
                'errorMessage' => 'Forbidden',
                'errorCode' => 'FORBIDDEN',
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
        $shipmentsClient = new FbsShipmentsGetClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $shipmentsClient->get('16393450000');
    }

    public function testGetShipmentTooManyRequests(): void
    {
        $mock = new MockHandler([
            new Response(429, [], json_encode([
                'errorMessage' => 'Too many requests',
                'errorCode' => 'TOO_MANY_REQUESTS',
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
        $shipmentsClient = new FbsShipmentsGetClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $shipmentsClient->get('16393450000');
    }

    public function testGetShipmentServerError(): void
    {
        $mock = new MockHandler([
            new Response(500, [], json_encode([
                'errorMessage' => 'Internal server error',
                'errorCode' => 'INTERNAL_SERVER_ERROR',
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
        $shipmentsClient = new FbsShipmentsGetClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $shipmentsClient->get('16393450000');
    }
}