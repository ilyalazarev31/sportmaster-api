# FbsWarehousesListClient Documentation

The `FbsWarehousesListClient` class retrieves a list of FBS warehouses from the Sportmaster Seller API.

## Usage

### Listing FBS Warehouses

Retrieve a list of FBS warehouses with pagination.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsWarehousesListClient;
use Sportmaster\Api\Request\FbsWarehousesListRequest;

$client = new Client();
$client->setClientId('14700005');
$warehousesClient = new FbsWarehousesListClient($client);

$request = new FbsWarehousesListRequest(20, 0);
$response = $warehousesClient->list($request);

foreach ($response->getWarehouses() as $warehouse) {
    echo $warehouse['id'] . ': ' . $warehouse['name'] . PHP_EOL;
}
```

## Methods

### list(FbsWarehousesListRequest $request): FbsWarehousesListResponse

Retrieves a list of FBS warehouses.

- **Parameters**:
  - `FbsWarehousesListRequest $request`: Request object with limit and offset.
- **Returns**: `FbsWarehousesListResponse` object containing the list of warehouses and pagination.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).