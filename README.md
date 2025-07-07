# Sportmaster API Client

A flexible and extensible PHP client for interacting with the Sportmaster Seller API. This package supports both native PHP and frameworks like Laravel, with easy configuration, token management, and logging.

## Installation

Install the package via Composer:

```bash
composer require sportmaster/api-client
```

## Usage

### Basic Example (Native PHP)

```php
use Sportmaster\Api\Client;
use Sportmaster\Api\Endpoints\AuthClient;
use Sportmaster\Api\Request\AuthRequest;

$client = new Client();
$authClient = new AuthClient($client);

$request = new AuthRequest('your_client_id', 'your_client_secret');
$response = $authClient->authenticate($request);

echo $response->getAccessToken(); // Outputs the access token
```

### Laravel Integration

Add the service provider to `config/app.php`:

```php
'providers' => [
    Sportmaster\Api\Laravel\SportmasterApiServiceProvider::class,
]
```

Use the client in your application:

```php
use Sportmaster\Api\Endpoints\AuthClient;
use Sportmaster\Api\Request\AuthRequest;

$client = app(\Sportmaster\Api\Client::class);
$authClient = new AuthClient($client);

$request = new AuthRequest('your_client_id', 'your_client_secret');
$response = $authClient->authenticate($request);

echo $response->getAccessToken();
```

## Configuration

- **Token Storage**: By default, tokens are stored in a JSON file (`.sportmaster_token.json`). You can implement `TokenStorageInterface` for custom storage.
- **Logger**: By default, logs are written to `sportmaster_api.log`. Implement `LoggerInterface` for custom logging.
- **HTTP Client**: Uses Guzzle by default. Pass a custom `ClientInterface` to the `Client` constructor for alternative HTTP clients.

## Requirements

- PHP ^8.1
- Guzzle HTTP Client ^7.5
- Monolog ^3.0

## Testing

Run tests with PHPUnit:

```bash
composer test
```

## Documentation

Detailed documentation for each class is available in the `docs/` directory.