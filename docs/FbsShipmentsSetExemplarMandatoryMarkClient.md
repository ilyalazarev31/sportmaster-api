# FbsShipmentsSetExemplarMandatoryMarkClient Documentation

The `FbsShipmentsSetExemplarMandatoryMarkClient` class sets a mandatory mark on an exemplar in an FBS shipment in the Sportmaster Seller API (Beta).

## Usage

### Setting a Mandatory Mark

Set a mandatory mark on an exemplar in an FBS shipment.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsSetExemplarMandatoryMarkClient;
use Sportmaster\Api\Request\FbsShipmentsSetExemplarMandatoryMarkRequest;

$client = new Client();
$client->setClientId('14700005');
$markClient = new FbsShipmentsSetExemplarMandatoryMarkClient($client);

$request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
    '12376390',
    '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
);

$response = $markClient->setExemplarMandatoryMark('16393450000', $request);

echo $response->isMandatoryMarkSet() ? 'Mark set' : 'Mark not set';
```

### Handling Errors

```php
try {
    $request = new FbsShipmentsSetExemplarMandatoryMarkRequest(
        'invalid_id',
        '0106936982561755215&ZkzDYUwJvec9100C092UrMd+G7dzsmWfNMeyzRxRU5O4ZZM5qFqDbHRAwlceNuj042GgppycynGdgTvK8AIhJYKJb5+LL0xc64oP64LXg=='
    );
    $response = $markClient->setExemplarMandatoryMark('16393450000', $request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### setExemplarMandatoryMark(string $shipmentId, FbsShipmentsSetExemplarMandatoryMarkRequest $request): FbsShipmentsSetExemplarMandatoryMarkResponse

Sets a mandatory mark on an exemplar in an FBS shipment.

- **Parameters**:
  - `string $shipmentId`: Shipment ID (1–14 digits).
  - `FbsShipmentsSetExemplarMandatoryMarkRequest $request`: Request object with exemplar ID and mandatory mark.
- **Returns**: `FbsShipmentsSetExemplarMandatoryMarkResponse` object containing verification results.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).