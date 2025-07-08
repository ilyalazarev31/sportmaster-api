# FbsShipmentsGetClient Documentation

The `FbsShipmentsGetClient` class retrieves detailed information about an FBS shipment from the Sportmaster Seller API (Beta).

## Usage

### Retrieving Shipment Details

Retrieve detailed information about an FBS shipment by its ID.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsGetClient;

$client = new Client();
$client->setClientId('14700005');
$shipmentsClient = new FbsShipmentsGetClient($client);

$response = $shipmentsClient->get('16393450000');

echo $response->getStatus(); // Outputs the shipment status
echo $response->getOrderNumber(); // Outputs the order number
```

### Handling Errors

```php
try {
    $response = $shipmentsClient->get('invalid_id');
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### get(string $shipmentId): FbsShipmentsGetResponse

Retrieves detailed information about an FBS shipment.

- **Parameters**:
  - `string $shipmentId`: Shipment ID (1–14 digits).
- **Returns**: `FbsShipmentsGetResponse` object containing shipment details.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).