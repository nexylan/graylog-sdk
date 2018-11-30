# Graylog SDK

Graylog API PHP SDK.

[![Latest Stable Version](https://poser.pugx.org/nexylan/graylog-sdk/v/stable)](https://packagist.org/packages/nexylan/graylog-sdk)
[![Latest Unstable Version](https://poser.pugx.org/nexylan/graylog-sdk/v/unstable)](https://packagist.org/packages/nexylan/graylog-sdk)
[![License](https://poser.pugx.org/nexylan/graylog-sdk/license)](https://packagist.org/packages/nexylan/graylog-sdk)

[![Total Downloads](https://poser.pugx.org/nexylan/graylog-sdk/downloads)](https://packagist.org/packages/nexylan/graylog-sdk)
[![Monthly Downloads](https://poser.pugx.org/nexylan/graylog-sdk/d/monthly)](https://packagist.org/packages/nexylan/graylog-sdk)
[![Daily Downloads](https://poser.pugx.org/nexylan/graylog-sdk/d/daily)](https://packagist.org/packages/nexylan/graylog-sdk)

## Documentation

All the installation and usage instructions are located in this README.
Check it for a specific versions:

* [__0.x__](https://github.com/nexylan/graylog-sdk/tree/master)

## Prerequisites

This version of the project requires:

* PHP 7.0+

## Installation

First of all, you need to require this library through Composer:

``` bash
composer require nexylan/graylog-sdk
```

## Usage

```php
$graylog = new \Nexy\Graylog\Graylog([
    'base_uri' => 'https://your.graylog.instance.com/api'
]);

// You may authenticate with API token:
$graylog->auth('YourApiToken');
// Or user credentials:
$graylog->auth('YourGraylogUsername', 'YourGrayLogPassword');

// Then, start using the API:
$result = $graylog->search()->relative()->terms('file', 'source: host.com', 0);
```

### Symfony integration

Activate the bundle:

```php
// config/bundles.php

return [
    Nexy\Graylog\Bridge\Symfony\Bundle\NexyGraylogBundle::class => ['all' => true],
];
```

Add the configuration file:

```yaml
// config/packages/nexy_graylog.yaml

nexy_graylog:
    options:
        base_uri:             ~ # Required
    auth:

        # Can be a username or a token.
        user:                 ~ # Required

        # Required only for username auth.
        password:             null
```

Then, inject the Graylog service thanks to autowiring:

```php
class MyService
{
    private $graylog;

    public function __construct(Nexy\Graylog\Graylog $graylog)
    {
        $this->graylog = $graylog;
    }
}
```
