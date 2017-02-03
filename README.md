# dislo-sdk
PHP SDK for the Dislo API

## Installation

## Usage

### Instantiate the Client
The client itself uses a RequestClient interface to communicate with the Dislo API. When running in CDE the RequestClient can be omitted, causing the client to use CDE's internal functions.

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

    $apiClient = new \Ixolit\Dislo\Client();

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

    $apiClient = new \Ixolit\Dislo\Client();
    
    try {
        $user = $client->userGet($token);
    }
    catch (\Ixolit\Dislo\Exceptions\InvalidTokenException $e) {
        // token invalid, e.g. expired
        setcookie('authToken', null, -1);
    }

A token's expiry time is extended automatically on usage.

Verify a token, explicitly extend its expiry time and optionally change its lifetime:

    $token = getcookie('authToken');

    $apiClient = new \Ixolit\Dislo\Client();
    
    try {
        $response = $client->userExtendToken($token, $ipAdress, 3600);
        $authToken = $response->getAuthToken();
        echo $authToken->getValidUntil()->format('c');
    }
    catch (\Ixolit\Dislo\Exceptions\InvalidTokenException $e) {
        // token invalid, e.g. expired
        setcookie('authToken', null, -1);
    }

Deauthenticate:

    $client->userDeauthenticate($token);
    setcookie('authToken', null, -1);
