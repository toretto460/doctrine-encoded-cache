<?php

require_once __DIR__ . '/bootstrap.php';

use Trt\Doctrine\Cache\Encryptor\AES256Encryptor;
use Trt\Doctrine\Cache\Provider\CacheProviderDecorator;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\Cache;

$doctrineCache = new ApcCache();
$encodedCache  = new CacheProviderDecorator(
    $doctrineCache,
    new AES256Encryptor('my_key')
);

$counter = 100;
$stringLength = 50000;


function test($counter, $stringLength, Cache $cache) {

    $start = microtime(true);

    foreach(range(0, $counter) as $key) {

        $cache->save($key, str_pad('', $stringLength, '.'), 30);
        $cache->fetch($key);
        $cache->delete($key);
    }

    return number_format(microtime(true) - $start, 10);
}


$plainTime = test($counter, $stringLength, $doctrineCache);
echo "Without Encoding: " . $plainTime . "\n";

$encodedTime = test($counter, $stringLength, $encodedCache);
echo "With Encoding: " . $encodedTime . "\n";
