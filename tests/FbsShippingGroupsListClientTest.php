<?php

namespace Sportmaster\Api\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShippingGroupsListClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShippingGroupsListRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShippingGroupsListClientTest extends TestCase
{
    public function testListShippingGroupsSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'shippingGroups' => [
                    [
                        'id' => '12376390',
                        'status' => 'READY_TO_SHIP',
                        'shipmentIds' => ['16393450000'],
                        'courierCompany' => [
                            'id' => '12376390',
                            'name' => 'ООО «Быстрые Колеса»',
                        ],
                        'createDate' => '2025-03-24T18:40:44+03:00',
                        'lastStatusDate' => '2025-03-28T08:40:44+03:00',
                        'shippingGroupNumber' => '3163',
                        'batchNumInCC' => '9001454',
                    ],
                ],
                'pagination' => [
                    'limit' => 20,
                    'offset' => 0,
                    'total' => 1,
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
        $shippingGroupsClient = new FbsShippingGroupsListClient($client);

        $request = new FbsShippingGroupsListRequest(
            ['12376390'],
            ['16393450000'],
            ['READY_TO_SHIP', 'SHIPPED'],
            20,
            0
        );

        try {
            $response = $shippingGroupsClient->list($request);
        } catch (ApiException $e) {
        }

        $this->assertCount(1, $response->getShippingGroups());
        $this->assertEquals(20, $response->getPagination()['limit']);
        $this->assertEquals(0, $response->getPagination()['offset']);
        $this->assertEquals(1, $response->getPagination()['total']);
    }

    public function testListShippingGroupsInvalidRequest(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shippingGroupsClient = new FbsShippingGroupsListClient($client);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Statuses array must not be empty');

        new FbsShippingGroupsListRequest([], [], [], 20, 0);
    }
}