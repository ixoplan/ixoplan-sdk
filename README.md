# dislo-sdk
PHP SDK for the Dislo API

## Installation

Simply add `ixolit/dislo-sdk` and a provider of `ixolit/dislo-sdk-http` (e.g. ixolit/dislo-sdk-http-guzzle) to your composer.json, e.g:

```json
    {
        "name": "myvendor/myproject",
        "description": "Using dislo-sdk",
        "require": {
            "ixolit/dislo-sdk": "*",
            "ixolit/dislo-sdk-http-guzzle": "*"
        }
    }
```

## Usage

### Instantiate the Client
The client is designed for different transport layers. It needs a RequestClient interface (e.g. HTTPRequestClient) to actually communicate with Dislo.

```php
    use Ixolit\Dislo\Client;
    use Ixolit\Dislo\HTTP\Guzzle\GuzzleHTTPClientAdapter;
    use Ixolit\Dislo\Request\HTTPRequestClient;
    
    $httpAdapter = new GuzzleHTTPClientAdapter();

    $httpClient = new HTTPRequestClient(
        $httpAdapter,
        $host,
        $apiKey,
        $apiSecret
    );

    $apiClient = new Client($httpClient);
```

Most methods related to user data can be used with either a user ID, a `\Ixolit\Dislo\WorkingObjects\User` object or an authentication token. However, the less secure options have to be requested explicitely by passing `$forceTokenMode = false` to the constructor. Don't use this option unless you really need it, e.g. for implementing administrative functionality.

### Login
Authenticate user, retrieve token and user data:

```php
    $apiClient = new \Ixolit\Dislo\Client($httpClient);

    try {
        $authResponse = $apiClient->userAuthenticate(
            $userEmail,
            $password,
            $ipAddress
        );

        $authToken = $authResponse->getAuthToken();
        setcookie('authToken', $authToken);
        
        $user = $response->getUser();
        echo $user->getLastLoginDate();
    }
    catch (\Ixolit\Dislo\Exceptions\AuthenticationInvalidCredentialsException $e) {
        // invalid credentials
        echo $e->getMessage();
    }
```

Get user from token:

```php
    $token = getcookie('authToken');

    $apiClient = new \Ixolit\Dislo\Client($httpClient);
    
    try {
        $user = $apiClient->userGet($token);
    }
    catch (\Ixolit\Dislo\Exceptions\InvalidTokenException $e) {
        // token invalid, e.g. expired
        setcookie('authToken', null, -1);
    }
    catch (\Ixolit\Dislo\Exceptions\DisloException $e) {
        // other, e.g. missing arguments
    }
```

A token's expiry time is extended automatically on usage.

Verify a token, explicitly extend its expiry time and optionally change its lifetime:

```php
    $token = getcookie('authToken');

    $apiClient = new \Ixolit\Dislo\Client($httpClient);
    
    try {
        $response = $apiClient->userExtendToken($token, $ipAdress, 3600);
        $authToken = $response->getAuthToken();
        echo $authToken->getValidUntil()->format('c');
    }
    catch (\Ixolit\Dislo\Exceptions\InvalidTokenException $e) {
        // token invalid, e.g. expired
        setcookie('authToken', null, -1);
    }
    catch (\Ixolit\Dislo\Exceptions\DisloException $e) {
        // other, e.g. missing arguments
    }
```

Deauthenticate:

```php
    $apiClient->userDeauthenticate($token);
    setcookie('authToken', null, -1);
```

### Packages

Retrieve a list of packages, optionally filtered by service ID:

```php
    $apiClient = new \Ixolit\Dislo\Client($httpClient);

    $response = $apiClient->packagesList("1");

    foreach ($response->getPackages() as $package) {
        echo $package->getDisplayNameForLanguage('en')->getName(), "\n";
    }
```

### Subscriptions

Retrieve a list of subscriptions for a user:

```php
    $apiClient = new \Ixolit\Dislo\Client($httpClient);

    $response = $apiClient->subscriptionGetAll($token);

    foreach ($response->getSubscriptions() as $subscription) {
        print_r([
            'status' => $subscription->getStatus(),
            'active' => $subscription->isActive(),
            'startedAt' => $subscription->getStartedAt()->format('c'),
            'package' => $subscription->getCurrentPackage()->getDisplayNameForLanguage('en')->getName(),
            'price (EU)' => $subscription->getCurrentPeriod()->getBasePriceForCurrency('EUR')->getAmount(),
            'metaData' => $subscription->getProvisioningMetaData(),
        ]);
    }
```

### Search API

Run a parametrized query against the search database in Dislo, pass a file resource to stream the returned data to.

```php
    $apiClient = new \Ixolit\Dislo\Client($httpClient);

    $date = date('Y-m-d');
    $file = fopen('/path/to/file', 'w');

    $apiClient->exportStreamQuery(
        'select * from users where last_indexed_at > :_last(date)',
        ['last' => $date],
        $file
    );
```
