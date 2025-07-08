# FbsShipmentsChangePackagesClient Documentation

The `FbsShipmentsChangePackagesClient` class changes packages for an FBS shipment in the Sportmaster Seller API (Beta).

## Usage

### Changing Shipment Packages

Change packages for an FBS shipment.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsChangePackagesClient;
use Sportmaster\Api\Request\FbsShipmentsChangePackagesRequest;

$client = new Client();
$client->setClientId('14700005');
$changeClient = new FbsShipmentsChangePackagesClient($client);

$request = new FbsShipmentsChangePackagesRequest(
    ['1863780471'],
    [
        [
            'weightAndSizeCharacteristics' => [
                'weight' => 54.34,
                'height' => 60,
                'length' => 24,
                'width' => 49,
            ],
            'exemplarIds' => ['812741293', '128373462'],
        ],
    ]
);

$changeClient->changePackages('16393450000', $request);
```

### Handling Errors

```php
try {
    $request = new FbsShipmentsChangePackagesRequest(
        ['invalid_id'],
        [
            [
                'weightAndSizeCharacteristics' => [
                    'weight' => 54.34,
                    'height' => 60,
                    'length' => 24,
                    'width' => 49,
                ],
                'exemplarIds' => ['812741293'],
            ],
        ]
    );
    $changeClient->changePackages('16393450000', $request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### changePackages(string $shipmentId, FbsShipmentsChangePackagesRequest $request): void

Changes packages for an FBS shipment.

- **Parameters**:
  - `string $shipmentId`: Shipment ID (1–14 digits).
  - `FbsShipmentsChangePackagesRequest $request`: Request object with rejected exemplar IDs and packages.
- **Returns**: None.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).