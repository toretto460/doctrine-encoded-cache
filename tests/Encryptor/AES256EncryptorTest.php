<?php
/**
 * Created by PhpStorm.
 * User: toretto
 * Date: 15/12/14
 * Time: 22:22
 */

namespace Trt\Doctrine\Cache\Tests\Encryptor;

use Trt\Doctrine\Cache\Encryptor\AES256Encryptor;

class AES256EncryptorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider provideDataToEncrypt
     */
    public function itShouldEncryptAndDecryptDataConsistently($data)
    {
        $encryptor = new AES256Encryptor(new StubbedKeyProvider('test_key'));

        $encryptedData = $encryptor->encrypt($data);

        $this->assertEquals($data, $encryptor->decrypt($encryptedData));
    }

    public function provideDataToEncrypt()
    {
        return [
            [1],
            [null],
            ['string'],
            [Text::$longText],
            [new \stdClass()],
            [new \DateTime('now')],
            [[new \stdClass(), new \DateTime('now')]]
        ];
    }

}
 