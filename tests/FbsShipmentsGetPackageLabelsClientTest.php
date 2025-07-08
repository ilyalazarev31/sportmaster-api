<?php

namespace Sportmaster\Api\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsGetPackageLabelsClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShipmentsGetPackageLabelsRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShipmentsGetPackageLabelsClientTest extends TestCase
{
    public function testGetPackageLabelsSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'fileContent' => 'aGVsbG8=',
                'fileName' => 'Этикетка_FBS_156064_АО Почта России.pdf',
                'getPackageLabelResults' => [
                    [
                        'shipmentId' => '1863780471',
                        'shipmentStatus' => 'TRANSFER_TO_DOP',
                        'result' => true,
                    ],
                    [
                        'shipmentId' => '1238671442',
                        'shipmentStatus' => 'SHIPPED',
                        'result' => false,
                        'error' => [
                            'code' => 'PACKAGE_ERROR',
                            'description' => 'Превышены ВГХ упаковочного места',
                        ],
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
        $labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

        $request = new FbsShipmentsGetPackageLabelsRequest(['1863780471', '1238671442']);
        try {
            $response = $labelsClient->getPackageLabels($request);
        } catch (ApiException $e) {
        }

        $this->assertEquals('aGVsbG8=', $response->getFileContent());
        $this->assertEquals('Этикетка_FBS_156064_АО Почта России.pdf', $response->getFileName());
        $this->assertCount(2, $response->getPackageLabelResults());
    }

    public function testGetPackageLabelsInvalidRequest(): void
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
        $labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Invalid request parameters');
        $this->expectExceptionCode(400);

        $request = new FbsShipmentsGetPackageLabelsRequest(['invalid_id']);
        $labelsClient->getPackageLabels($request);
    }

    public function testGetPackageLabelsUnauthorized(): void
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
        $labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Unauthorized');
        $this->expectExceptionCode(401);

        $request = new FbsShipmentsGetPackageLabelsRequest(['1863780471']);
        $labelsClient->getPackageLabels($request);
    }

    public function testGetPackageLabelsForbidden(): void
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
        $labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Forbidden');
        $this->expectExceptionCode(403);

        $request = new FbsShipmentsGetPackageLabelsRequest(['1863780471']);
        $labelsClient->getPackageLabels($request);
    }

    public function testGetPackageLabelsTooManyRequests(): void
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
        $labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Too many requests');
        $this->expectExceptionCode(429);

        $request = new FbsShipmentsGetPackageLabelsRequest(['1863780471']);
        $labelsClient->getPackageLabels($request);
    }

    public function testGetPackageLabelsServerError(): void
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

        $client = noneWorkingDaysClient($httpClient, $tokenStorage, $logger);
        $client->setClientId('14700005');
        $labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

        $this->expectException(\Sportmaster\Api\Exception\ApiException::class);
        $this->expectExceptionMessage('Internal server error');
        $this->expectExceptionCode(500);

        $request = new FbsShipmentsGetPackageLabelsRequest(['1863780471']);
        $labelsClient->getPackageLabels($request);
    }
}