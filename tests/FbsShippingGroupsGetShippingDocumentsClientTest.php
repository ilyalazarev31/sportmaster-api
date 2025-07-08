<?php

namespace Sportmaster\Api\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShippingGroupsGetShippingDocumentsClient;
use Sportmaster\Api\Exception\ApiException;
use Sportmaster\Api\Request\FbsShippingGroupsGetShippingDocumentsRequest;
use Sportmaster\Api\TokenStorage\TokenStorageInterface;
use Sportmaster\Api\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FbsShippingGroupsGetShippingDocumentsClientTest extends TestCase
{
    public function testGetShippingDocumentsSuccess(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'documents' => [
                    [
                        'type' => 'ACT',
                        'url' => 'https://example.com/act.pdf',
                    ],
                    [
                        'type' => 'LABEL',
                        'url' => 'https://example.com/label.pdf',
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
        $shippingGroupsClient = new FbsShippingGroupsGetShippingDocumentsClient($client);

        $request = new FbsShippingGroupsGetShippingDocumentsRequest('12376390', ['ACT', 'LABEL']);

        try {
            $response = $shippingGroupsClient->getShippingDocuments($request);
        } catch (ApiException $e) {
        }

        $this->assertCount(2, $response->getDocuments());
        $this->assertEquals('ACT', $response->getDocuments()[0]['type']);
        $this->assertEquals('https://example.com/act.pdf', $response->getDocuments()[0]['url']);
    }

    public function testGetShippingDocumentsInvalidRequest(): void
    {
        $client = new Client();
        $client->setClientId('14700005');
        $shippingGroupsClient = new FbsShippingGroupsGetShippingDocumentsClient($client);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Document types array must not be empty');

        new FbsShippingGroupsGetShippingDocumentsRequest('12376390', []);
    }
}