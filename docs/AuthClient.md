# AuthClient Documentation

The `AuthClient` class handles authentication with the Sportmaster Seller API to obtain an access token.

## Usage

### Authenticating with API Key

Obtain an access token using an API key and Client-ID.

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\AuthClient;
use Sportmaster\Api\Request\AuthRequest;

$client = new Client();
$client->setClientId('14700005');
$authClient = new AuthClient($client);

$request = new AuthRequest('550e8400-e29b-41d4-a716-446655440000');
$client->setAuthRequest($request); // Enable automatic token refresh
$response = $authClient->authenticate($request);

echo $response->getAccessToken(); // Outputs the access token
```

### Handling Errors

```php
try {
    $request = new AuthRequest('invalid-uuid');
    $response = $authClient->authenticate($request);
} catch (\Sportmaster\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}, Code: {$e->getErrorCode()}";
}
```

## Methods

### authenticate(AuthRequest $request): AuthResponse

Authenticates and retrieves an access token.

- **Parameters**:
  - `AuthRequest $request`: Request object with API key.
- **Returns**: `AuthResponse` object containing access token, expiration time, and token type.
- **Throws**: `ApiException` if the authentication fails (e.g., 400, 429, 500).