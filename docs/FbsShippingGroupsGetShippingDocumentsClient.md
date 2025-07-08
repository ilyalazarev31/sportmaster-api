# FbsShippingGroupsGetShippingDocumentsClient Documentation

The `FbsShippingGroupsGetShippingDocumentsClient` class retrieves shipping documents for a shipping group from the Sportmaster Seller API (Beta).

## Usage

### Retrieving Shipping Documents

Retrieve shipping documents for a specified shipping group.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShippingGroupsGetShippingDocumentsClient;
use Sportmaster\Api\Request\FbsShippingGroupsGetShippingDocumentsRequest;

$client = new Client();
$client->setClientId('14700005');
$shippingGroupsClient = new FbsShippingGroupsGetShippingDocumentsClient($client);

$request = new FbsShippingGroupsGetShippingDocumentsRequest('12376390', ['ACT', 'LABEL']);

$response = $shippingGroupsClient->getShippingDocuments($request);

foreach ($response->getDocuments() as $document) {
    echo $document['type'] . ": " . $document['url'] . "\n";
}
```

### Handling Errors

```php
try {
    $request = new FbsShippingGroupsGetShippingDocumentsRequest('12376390', []);
} catch (\InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}";
}
```

## Methods

### getShippingDocuments(FbsShippingGroupsGetShippingDocumentsRequest $request): FbsShippingGroupsGetShippingDocumentsResponse

Retrieves shipping documents for a specified shipping group.

- **Parameters**:
  - `FbsShippingGroupsGetShippingDocumentsRequest $request`: Request object with shipping group ID and document types.
- **Returns**: `FbsShippingGroupsGetShippingDocumentsResponse` object containing the document links.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).