# ProductPricesListClient Documentation

The `ProductPricesListClient` class retrieves a list of product prices from the Sportmaster Seller API.

## Usage

### Listing Product Prices

Retrieve a list of product prices with pagination.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\ProductPricesListClient;
use Sportmaster\Api\Request\ProductPricesListRequest;

$client = new Client();
$client->setClientId('14700005');
$pricesClient = new ProductPricesListClient($client);

$request = new ProductPricesListRequest(['T4P00911MDAW', 'BNN01821MEOW'], 100, 0);
$response = $pricesClient->list($request);

foreach ($response->getProductPrices() as $price) {
    echo $price['offerId'] . ': ' . $price['price'] . PHP_EOL;
}
```

### Handling Errors

```php
try {
    $request = new ProductPricesListRequest(['invalid@offer'], 20, 0);
    $response = $pricesClient->list($request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### list(ProductPricesListRequest $request): ProductPricesListResponse

Retrieves a list of product prices.

- **Parameters**:
  - `ProductPricesListRequest $request`: Request object with offer IDs, limit, and offset.
- **Returns**: `ProductPricesListResponse` object containing the list of prices and pagination.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).