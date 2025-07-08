# FbsShipmentsDeleteExemplarMandatoryMarkClient Documentation

The `FbsShipmentsDeleteExemplarMandatoryMarkClient` class deletes an exemplar mandatory mark from a specific FBS shipment in the Sportmaster Seller API (Beta).

## Usage

### Deleting an Exemplar Mandatory Mark

Delete an exemplar mandatory mark for a specified FBS shipment.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsDeleteExemplarMandatoryMarkClient;
use Sportmaster\Api\Request\FbsShipmentsDeleteExemplarMandatoryMarkRequest;

$client = new Client();
$client->setClientId('14700005');
$shipmentsClient = new FbsShipmentsDeleteExemplarMandatoryMarkClient($client);

$request = new FbsShipmentsDeleteExemplarMandatoryMarkRequest('2389472891');

$result = $shipmentsClient->deleteExemplarMandatoryMark('16393450000', $request);

if ($result) {
    echo "Exemplar mandatory mark deleted successfully";
}
```

### Handling Errors

```php
try {
    $request = new FbsShipmentsDeleteExemplarMandatoryMarkRequest('invalid_id');
} catch (\InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}";
}
```

## Methods

### deleteExemplarMandatoryMark(string $shipmentId, FbsShipmentsDeleteExemplarMandatoryMarkRequest $request): bool

Deletes an exemplar mandatory mark for a specified FBS shipment.

- **Parameters**:
  - `string $shipmentId`: Shipment ID (1–20 digits).
  - `FbsShipmentsDeleteExemplarMandatoryMarkRequest $request`: Request object with exemplar ID.
- **Returns**: `bool` true if the operation is successful.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).