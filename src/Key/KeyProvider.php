<?php

namespace Trt\Doctrine\Cache\Key;


interface KeyProvider
{
    /**
     * Provide the encoding key string.
     *
     * @return String
     */
    public function getKey();
}