# dislo-sdk
PHP SDK for the Dislo API

## Installation

Simply add ixolit/dislo-sdk to your composer.json, e.g:

    {
        "name": "myvendor/myproject",
        "description": "Using dislo-sdk",
        "require": {
            "ixolit/dislo-sdk": "*"
        }
    }

## Usage

### Instantiate the Client
The client is designed for different transport layers. It needs a RequestClient interface (e.g. HTTPRequestClient) to actually communicate with Dislo.

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

### Login
Authenticate user, retrieve token and user data:

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

Get user from token:

    $token = getcookie('authToken');

    $apiClient = new \Ixolit\Dislo\Client($httpClient);
    
    try {
        $user = $client->userGet($token);
    }
    catch (\Ixolit\Dislo\Exceptions\InvalidTokenException $e) {
        // token invalid, e.g. expired
        setcookie('authToken', null, -1);
    }
    catch (\Ixolit\Dislo\Exceptions\DisloException $e) {
        // other, e.g. missing arguments
    }

A token's expiry time is extended automatically on usage.

Verify a token, explicitly extend its expiry time and optionally change its lifetime:

    $token = getcookie('authToken');

    $apiClient = new \Ixolit\Dislo\Client($httpClient);
    
    try {
        $response = $client->userExtendToken($token, $ipAdress, 3600);
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

Deauthenticate:

    $client->userDeauthenticate($token);
    setcookie('authToken', null, -1);

### Packages

Retrieve a list of packages, optionally filtered by service ID:

    $apiClient = new \Ixolit\Dislo\Client($httpClient);

    $response = $apiClient->packagesList("1");

    foreach ($response->getPackages() as $package) {
        echo $package->getDisplayNameForLanguage('en')->getName(), "\n";
    }

### Subscriptions

Retrieve a list of subscriptions for a user:

    $apiClient = new \Ixolit\Dislo\Client($httpClient);

    $response = $client->subscriptionGetAll($token);

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
