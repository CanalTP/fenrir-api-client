Fenrir Api Client
=================

PHP client for Fenrir Api.


## Composer

Install via composer:

``` js
{
    "require": {
        "canaltp/fenrir-api-client": "~1.0"
    }
}
```


## Usage

### Instanciating a client

Instanciate a new client. Your client needs a Guzzle client.
Fenrir Api client works with either Guzzle3 or Guzzle5.

``` php
use CanalTP\FenrirApiClient\FenrirApi;
use CanalTP\FenrirApiClient\AbstractGuzzle\Version;

$baseUrl = 'http://fenrir-api.local/';

$fenrirApi = new FenrirApi(new Version\Guzzle5($baseUrl)); // For Guzzle 5
$fenrirApi = new FenrirApi(new Version\Guzzle3($baseUrl)); // For Guzzle 3
```

Or to abstract Guzzle client version, use the Guzzle client factory:

``` php
use CanalTP\FenrirApiClient\FenrirApi;
use CanalTP\FenrirApiClient\AbstractGuzzle\GuzzleVersions;

$baseUrl = 'http://fenrir-api.local/';

$fenrirApi = new FenrirApi(GuzzleVersions::createGuzzle($baseUrl));
```


### Call Fenrir Api

Retrieve all users:

``` php
$users = $fenrirApi->getUsers(); // Returns an array of stdClass.
```

Retrieve one user:

``` php
$user = $fenrirApi->getUser(1); // Returns an stdClass.
```

Create an user:

``` php
$username = 'tyler-durden';
$originId = 2;

$fenrirApi->postUser($username, $originId, [
    'enabled' => true,
    'locked' => '0',
]);
```

See the [complete Fenrir Api client class](src/FenrirApi.php).


## Testing


## License

This project is under [GPL-3.0 License](LICENSE).
