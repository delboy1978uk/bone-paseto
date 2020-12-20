# paseto
Paseto package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-paseto
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\Paseto\PasetoPackage;

return [
    'packages' => [
        // packages here...,
        PasetoPackage::class,
    ],
    // ...
];
```