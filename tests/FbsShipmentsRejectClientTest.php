<?php

namespace Sportmaster\Api\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsRejectClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShipmentsRejectRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShipmentsRejectClientTest extends TestCase
{
    public function testRejectShipmentSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([], JSON_THROW_ON_ERROR)),
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
        $shipmentsClient = new FbsShipmentsRejectClient($client);

        $request = new FbsShipmentsRejectRequest('16393450000', 'Product not available');

        try {
            $result = $shipmentsClient->reject($request);
        } catch (ApiException $e) {
        }

        $this->assertTrue($result);
    }

    public function testRejectShipmentInvalidRequest(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shipmentsClient = new FbsShipmentsRejectClient($client);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Reason must be 1–255 characters');

        new FbsShipmentsRejectRequest('16393450000', '');
    }
}