# bone-paseto
Platform agnostic security tokens for Bone Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-paseto
```
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
and add a `config/` folder setting for `bone-paseto` with a 32 character sharedKey
```php
<?php

return [
    'bone-paseto' => [
        'sharedKey' => 'tH1rtYtw0Ch4r4ct3rPasswordBlahXx',
    ],
];
```
## usage
In your package class, you can call the  service from the container and pass it into your controller or other classes.
```php
$service = $c->get(Bone\Paseto\PasetoService::class);
```
### encrypting and decrypting tokens
To encrypt a token, pass in the array of data and a string representation of a `TimeInterval` such as `P01D`.
```php
$token = $this->paseto->encryptToken(['testing' => 123], 'P07D');
echo $token;
```
which will output
```
v2.local.c_0Nhh-hNPj5PYfZSANhI5TbJAD7MbEwxX8xBZcR1hzhtBOcAmtdTHdRKCTPGioxR0Qa8Bzs1f0xw1BsGgr2mjb6RjnECYTMXHFNbF5q86lkvqWqOxRPYIc
```
To decrypt a token, just pass it in!
```php
$token = $this->paseto->decryptToken($bigLongTokenStringHere);
var_dump($token->getClaims());
```
```
array (size=2)
  'testing' => int 123
  'exp' => string '2020-12-27T07:46:22+00:00' (length=25)
```