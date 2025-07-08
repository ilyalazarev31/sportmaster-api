<?php

namespace Sportmaster\Api\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsDeleteExemplarMandatoryMarkClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShipmentsDeleteExemplarMandatoryMarkRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShipmentsDeleteExemplarMandatoryMarkClientTest extends TestCase
{
    public function testDeleteExemplarMandatoryMarkSuccess(): void
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
        $shipmentsClient = new FbsShipmentsDeleteExemplarMandatoryMarkClient($client);

        $request = new FbsShipmentsDeleteExemplarMandatoryMarkRequest('2389472891');

        try {
            $result = $shipmentsClient->deleteExemplarMandatoryMark('16393450000', $request);
        } catch (ApiException $e) {
        }

        $this->assertTrue($result);
    }

    public function testDeleteExemplarMandatoryMarkInvalidShipmentId(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shipmentsClient = new FbsShipmentsDeleteExemplarMandatoryMarkClient($client);

        $request = new FbsShipmentsDeleteExemplarMandatoryMarkRequest('2389472891');

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid shipmentId format, must be 1–20 digits');
        $this->expectExceptionCode(400);

        $shipmentsClient->deleteExemplarMandatoryMark('invalid_id', $request);
    }

    public function testDeleteExemplarMandatoryMarkInvalidRequest(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shipmentsClient = new FbsShipmentsDeleteExemplarMandatoryMarkClient($client);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid exemplarId format, must be 1–20 digits');

        new FbsShipmentsDeleteExemplarMandatoryMarkRequest('invalid_id');
    }
}