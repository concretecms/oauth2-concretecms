# concrete5 provider for OAuth 2.0 Client

This package provides concrete5 OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require concrete5/oauth2-concrete5
```

## Requirements

You must be running concrete5 8.5.0 or greater on your concrete5 website. Additionally, you must create an API Integration with Standard User Consent from the Dashboard > System > API > Integrations page. This integration will create a client ID and a client secret that you will use below.

## Usage

Usage is the same as The League's OAuth client, using `\Concrete\OAuth2\Client\Provider\Concrete5` as the provider.

### Authorization Code Flow

```php
$provider = new Concrete\OAuth2\Client\Provider\Concrete5([
    'clientId'          => '{integrationClientId}',
    'clientSecret'      => '{integrationClientSecret}',
    'redirectUri'       => 'https://example.com/callback-url'
]);

if (!isset($_GET['code'])) {

    $url = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getUserName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Credits

- [Andrew Embler](http://andrewembler.com)


## License

The MIT License (MIT). Please see LICENSE.TXT for more info.