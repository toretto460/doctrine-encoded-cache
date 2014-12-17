<?php
/**
 * Created by PhpStorm.
 * User: toretto
 * Date: 17/12/14
 * Time: 21:23
 */

namespace Trt\Doctrine\Cache\Tests\Encryptor;


use Trt\Doctrine\Cache\Key\KeyProvider;

class StubbedKeyProvider implements KeyProvider
{
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Provide the encoding key string.
     *
     * @return String
     */
    public function getKey()
    {
        return $this->key;
    }
}