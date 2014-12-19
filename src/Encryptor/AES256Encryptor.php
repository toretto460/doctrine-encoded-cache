<?php
/**
 * Created by PhpStorm.
 * User: toretto
 * Date: 13/12/14
 * Time: 12:25
 */

namespace Trt\Doctrine\Cache\Encryptor;

use Trt\Doctrine\Cache\Key\KeyProvider;

class AES256Encryptor implements Encryptor
{
    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var string
     */
    private $initializationVector;

    /**
     * {@inheritdoc}
     */
    public function __construct(KeyProvider $keyProvider)
    {
        $this->secretKey = md5($keyProvider->getKey());
        $this->initializationVector = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB),
            MCRYPT_RAND
        );
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($data)
    {
        return trim(
            base64_encode(
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_256,
                    $this->secretKey,
                    serialize($data),
                    MCRYPT_MODE_ECB,
                    $this->initializationVector
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    function decrypt($data)
    {
        return unserialize(
            trim(
                mcrypt_decrypt(
                    MCRYPT_RIJNDAEL_256,
                    $this->secretKey,
                    base64_decode($data),
                    MCRYPT_MODE_ECB,
                    $this->initializationVector
                )
            )
        );
    }

}