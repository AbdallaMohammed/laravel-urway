## URWAY Payment Gateway (Laravel Package)

### Installation

```bash
composer require abdallahmohammed/urway-laravel
```

In Laravel starting from 6.x the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
    URWay\URWayServiceProvider::class,
],
```

You can optionally register the facade in `config/app.php`

```php
'facades' => [
    // ...
    'URWay' => URWay\Facade\URWay::class,
],
```

You can publish using the following command

```bash
php artisan vendor:publish --provider="URWay\URWayServiceProvider"
```

When published, the `config/urway.php` config file contains:

```php
<?php

return [
    'mode' => env('URWAY_MODE', 'test'),
    'auth' => [
        'terminal_id' => env('URWAY_TERMINAL_ID'),
        'password' => env('URWAY_PASSWORD'),
        'merchant_key' => env('URWAY_MERCHANT_KEY'),
    ],
];
```

### Usage

```php
use URWay\Client;

// Create clint instance.
$client = new Client();

$client->setTrackId('YOUR_TRAKING_ID')
        ->setCustomerEmail('...')
        ->setCustomerIp('...')
        ->setCurrency('USD')
        ->setCountry('EG')
        ->setAmount(5)
        ->setRedirectUrl('...');

// Replace presented attributes with the given array.
$client->setAttributes([
    '...' => '...'
]);

// Merge presented attributes the given array.
$client->mergeAttributes([
    '...' => '...'
]);

// Replace one of presented attributes with the new value.
$client->setAttribute('...', '...');

// Remove one of attributes.
$client->removeAttribute('...');

// Determine whether an attribute exists.
$client->hasAttribute('...'); // returns boolean (true, or false)

$redirect_url = $client->pay();

return redirect()->url($redirect_url);
```

And on callback to handle response put the following code:

```php
use URWay\Client;

// Create clint instance.
$client = new Client();

$response = $client->find('TRANSACTION_ID');

if ($response->isSuccess()) {
    //
}

if ($response->isFailure()) {
    //
}

// To dump all payment details.
dd($response);
```

#### Production

To use this package in production mode, just update the `mode` value to `production` in the `config/urway.php` file.