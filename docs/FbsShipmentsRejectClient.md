# FbsShipmentsRejectClient Documentation

The `FbsShipmentsRejectClient` class rejects an FBS shipment in the Sportmaster Seller API (Beta).

## Usage

### Rejecting a Shipment

Reject an FBS shipment with a specified reason.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsRejectClient;
use Sportmaster\Api\Request\FbsShipmentsRejectRequest;

$client = new Client();
$client->setClientId('14700005');
$shipmentsClient = new FbsShipmentsRejectClient($client);

$request = new FbsShipmentsRejectRequest('16393450000', 'Product not available');

$result = $shipmentsClient->reject($request);

if ($result) {
    echo "Shipment rejected successfully";
}
```

### Handling Errors

```php
try {
    $request = new FbsShipmentsRejectRequest('16393450000', '');
} catch (\InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}";
}
```

## Methods

### reject(FbsShipmentsRejectRequest $request): bool

Rejects an FBS shipment with a specified reason.

- **Parameters**:
  - `FbsShipmentsRejectRequest $request`: Request object with shipment ID and reason.
- **Returns**: `bool` true if the operation is successful.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).