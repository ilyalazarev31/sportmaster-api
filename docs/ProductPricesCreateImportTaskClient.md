# ProductPricesCreateImportTaskClient Documentation

The `ProductPricesCreateImportTaskClient` class creates a task to import product prices in the Sportmaster Seller API.

## Usage

### Creating a Prices Import Task

Create a task to import product prices.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesCreateImportTaskClient;
use Sportmaster\Api\Request\ProductPricesCreateImportTaskRequest;
use Sportmaster\Api\Request\PriceItem;

$client = new Client();
$client->setClientId('14700005');
$importClient = new ProductPricesCreateImportTaskClient($client);

$prices = [
    new PriceItem('T4P00911MDAW', 99.99, 89.99),
    new PriceItem('BNN01821MEOW', 149.99),
];
$request = new ProductPricesCreateImportTaskRequest($prices);
$response = $importClient->create($request);

echo $response->getTaskId(); // Outputs the task ID
```

### Handling Errors

```php
try {
    $prices = [];
    $request = new ProductPricesCreateImportTaskRequest($prices);
    $response = $importClient->create($request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### create(ProductPricesCreateImportTaskRequest $request): ProductPricesCreateImportTaskResponse

Creates a task to import product prices.

- **Parameters**:
  - `ProductPricesCreateImportTaskRequest $request`: Request object with price items.
- **Returns**: `ProductPricesCreateImportTaskResponse` object containing the task ID.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).