# FbsShippingGroupsClient Documentation

The `FbsShippingGroupsClient` class creates a shipping group in the Sportmaster Seller API (Beta).

## Usage

### Creating a Shipping Group

Create a shipping group with specified shipments and courier company.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShippingGroupsClient;
use Sportmaster\Api\Request\FbsShippingGroupsRequest;

$client = new Client();
$client->setClientId('14700005');
$shippingGroupsClient = new FbsShippingGroupsClient($client);

$request = new FbsShippingGroupsRequest(['16393450000', '16393450001'], '12376390');

$response = $shippingGroupsClient->create($request);

echo $response->getShippingGroupId();
```

### Handling Errors

```php
try {
    $request = new FbsShippingGroupsRequest([], '12376390');
} catch (\InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}";
}
```

## Methods

### create(FbsShippingGroupsRequest $request): FbsShippingGroupsResponse

Creates a shipping group with specified shipments.

- **Parameters**:
  - `FbsShippingGroupsRequest $request`: Request object with shipment IDs and courier company ID.
- **Returns**: `FbsShippingGroupsResponse` object containing the created shipping group details.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).