<?php
/**
 * Created by PhpStorm.
 * User: toretto
 * Date: 13/12/14
 * Time: 12:23
 */

namespace Trt\Doctrine\Cache\Encryptor;


interface Encryptor
{
    /**
     * Must accept data and return encrypted data.
     */
    public function encrypt($data);

    /**
     * Must accept data and return decrypted data.
     */
    public function decrypt($data);
}