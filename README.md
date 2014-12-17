Doctrine Encrypted Cache Decorator
==================================

Sometimes for security constraints may not be possible to store plain data to the web server or cache server. This library allows to encode / decode doctrine cached data.


## Usage

```php

$doctrineCache = new \Doctrine\Common\Cache\ApcCache();

$encodedCache = new \Trt\Doctrine\Cache\Provider\CacheProviderDecorator(
    $doctrineCache,
    new \Trt\Doctrine\Cache\Encryptor\Encryptor('my_key')
);

$encodedCache->save('id', .... );

$encodedCache->fetch('id');

```
