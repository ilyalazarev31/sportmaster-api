# FbsStocksListClient Documentation

The `FbsStocksListClient` class retrieves a list of FBS stocks for a specific warehouse from the Sportmaster Seller API.

## Usage

### Listing FBS Stocks

Retrieve a list of FBS stocks with pagination.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsStocksListClient;
use Sportmaster\Api\Request\FbsStocksListRequest;

$client = new Client();
$client->setClientId('14700005');
$stocksClient = new FbsStocksListClient($client);

$request = new FbsStocksListRequest('32660299', 20, 0);
$response = $stocksClient->list($request);

foreach ($response->getStocks() as $stock) {
    echo $stock['offerId'] . ': ' . $stock['warehouseStock'] . PHP_EOL;
}
```

## Methods

### list(FbsStocksListRequest $request): FbsStocksListResponse

Retrieves a list of FBS stocks for a specific warehouse.

- **Parameters**:
  - `FbsStocksListRequest $request`: Request object with warehouse ID, limit, and offset.
- **Returns**: `FbsStocksListResponse` object containing the list of stocks and pagination.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).