# The CRM client package #

Provides an interface to send data to the CRM.

## Installation

Ensure you have composer installed, then run the following command:

```shell
$ composer require donttrythisathome/crm-client
```

## Basic usage ##

```php
$config = [
    'default' => 'baz',
    'drivers' => [
        'baz' => [
            'api_token' => $token, 
            'endpoint' => $endpoint          
        ]           
    ]
];
$data = ['foo' => 'bar'];

$crm = new \Donttrythisathome\CRMClient\CRMManager($config);

// send data using default driver
$crm->driver()->send($data);
// or
$crm->send($data)
 
// you can specify the CRM driver name 
$crm->driver('baz')->send($data);
```

## Bonus ##

Package supports laravel-way usage. Just require a package to your laravel 7 or 8 project and inject manager to you
class (or attempt to use facade class ).

### Example ###

```php

use Donttrythisathome\CRMClient\CRMManager;
use Donttrythisathome\CRMClient\Facades\CRM;

...

protected CRMManager $crm;

/**
 * @param \Donttrythisathome\CRMClient\CRMManager $crm
 */
public function __construct(CRMManager $crm) {
    $this->crm = $crm;
}

/**
 * @param array $data
 */
public function foo(array $data) {
    // send data using default driver or specify driver with driver(string $driver)
    $this->crm->send($data);
    // or 
    CRM::send($data);
}
```

### ENV ###

```dotenv
# configure Baz CRM endpoint
BAZ_CRM_ENDPOINT=https://foo.tld/bar
# configure Baz CRM access token
BAZ_CRM_ACCESS_TOKEN=abcdef


```