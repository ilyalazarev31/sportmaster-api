# ProductPricesGetImportTaskByIdClient Documentation

The `ProductPricesGetImportTaskByIdClient` class retrieves the status of a product prices import task from the Sportmaster Seller API.

## Usage

### Retrieving a Prices Import Task Status

Retrieve the status of a product prices import task.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesGetImportTaskByIdClient;
use Sportmaster\Api\Request\ProductPricesGetImportTaskByIdRequest;

$client = new Client();
$client->setClientId('14700005');
$taskClient = new ProductPricesGetImportTaskByIdClient($client);

$request = new ProductPricesGetImportTaskByIdRequest('1245212');
$response = $taskClient->get($request);

echo $response->getStatus(); // Outputs the task status
```

### Handling Errors

```php
try {
    $request = new ProductPricesGetImportTaskByIdRequest('invalid_id');
    $response = $taskClient->get($request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### get(ProductPricesGetImportTaskByIdRequest $request): ProductPricesGetImportTaskByIdResponse

Retrieves the status of a product prices import task.

- **Parameters**:
  - `ProductPricesGetImportTaskByIdRequest $request`: Request object with task ID.
- **Returns**: `ProductPricesGetImportTaskByIdResponse` object containing task details and status.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).