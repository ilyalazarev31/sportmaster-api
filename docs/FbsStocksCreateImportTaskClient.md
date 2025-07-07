# FbsStocksCreateImportTaskClient Documentation

The `FbsStocksCreateImportTaskClient` class creates a task to import FBS stocks in the Sportmaster Seller API.

## Usage

### Creating an FBS Stocks Import Task

Create a task to import stock quantities for a specific warehouse.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsStocksCreateImportTaskClient;
use Sportmaster\Api\Request\FbsStocksCreateImportTaskRequest;
use Sportmaster\Api\Request\StockItem;

$client = new Client();
$client->setClientId('14700005');
$importClient = new FbsStocksCreateImportTaskClient($client);

$stocks = [
    new StockItem('EIFJM1VRHE', 10),
    new StockItem('M04IPXX5KS', 20),
];
$request = new FbsStocksCreateImportTaskRequest('32660299', $stocks);
$response = $importClient->create($request);

echo $response->getTaskId(); // Outputs the task ID
```

## Methods

### create(FbsStocksCreateImportTaskRequest $request): FbsStocksCreateImportTaskResponse

Creates a task to import FBS stocks.

- **Parameters**:
  - `FbsStocksCreateImportTaskRequest $request`: Request object with warehouse ID and stock items.
- **Returns**: `FbsStocksCreateImportTaskResponse` object containing the task ID.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).