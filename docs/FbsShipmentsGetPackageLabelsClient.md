# FbsShipmentsGetPackageLabelsClient Documentation

The `FbsShipmentsGetPackageLabelsClient` class retrieves package labels for FBS shipments from the Sportmaster Seller API (Beta).

## Usage

### Retrieving Package Labels

Retrieve package labels for specified FBS shipments.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\FbsShipmentsGetPackageLabelsClient;
use Sportmaster\Api\Request\FbsShipmentsGetPackageLabelsRequest;

$client = new Client();
$client->setClientId('14700005');
$labelsClient = new FbsShipmentsGetPackageLabelsClient($client);

$request = new FbsShipmentsGetPackageLabelsRequest(['1863780471', '1238671442']);
$response = $labelsClient->getPackageLabels($request);

echo $response->getFileName(); // Outputs the file name
file_put_contents($response->getFileName(), base64_decode($response->getFileContent()));
```

### Handling Errors

```php
try {
    $request = new FbsShipmentsGetPackageLabelsRequest(['invalid_id']);
    $response = $labelsClient->getPackageLabels($request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### getPackageLabels(FbsShipmentsGetPackageLabelsRequest $request): FbsShipmentsGetPackageLabelsResponse

Retrieves package labels for FBS shipments.

- **Parameters**:
  - `FbsShipmentsGetPackageLabelsRequest $request`: Request object with shipment IDs.
- **Returns**: `FbsShipmentsGetPackageLabelsResponse` object containing file content and results.
- **Throws**: `ApiException` if the request fails (e.g., 400, 401, 403, 429, 500).