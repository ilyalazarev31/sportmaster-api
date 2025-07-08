# FbsShippingGroupsListClient Documentation

The `FbsShippingGroupsListClient` class retrieves a list of shipping groups from the Sportmaster Seller API (Beta).

## Usage

### Retrieving Shipping Groups

Retrieve a list of shipping groups.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShippingGroupsListClient;
use Sportmaster\Api\Request\FbsShippingGroupsListRequest;

$client = new Client();
$client->setClientId('14700005');
$shippingGroupsClient = new FbsShippingGroupsListClient($client);

$request = new FbsShippingGroupsListRequest(
    ['12376390'],
    ['16393450000'],
    ['READY_TO_SHIP', 'SHIPPED'],
    20,
    0
);

$response = $shippingGroupsClient->list($request);

foreach ($response->getShippingGroups() as $group) {
    echo $group['id'] . ": " . $group['status'] . "\n";
}
```

### Handling Errors

```php
try {
    $request = new FbsShippingGroupsListRequest([], [], [], 20, 0);
} catch (\InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}";
}
```

## Methods

### list(FbsShippingGroupsListRequest $request): FbsShippingGroupsListResponse

Retrieves a list of shipping groups.

- **Parameters**:
  - `FbsShippingGroupsListRequest $request`: Request object with shipping group IDs, shipment IDs, statuses, limit, and offset.
- **Returns**: `FbsShippingGroupsListResponse` object containing the list of shipping groups and pagination.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).