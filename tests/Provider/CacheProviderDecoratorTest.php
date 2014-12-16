<?php
/**
 * Created by PhpStorm.
 * User: toretto
 * Date: 16/12/14
 * Time: 22:02
 */

namespace Trt\Doctrine\Cache\Tests\Provider;


use Trt\Doctrine\Cache\Provider\CacheProviderDecorator;

class CacheProviderDecoratorTest extends \PHPUnit_Framework_TestCase
{

    private $cacheProvider;

    private $encryptor;

    public function setUp()
    {
        $this->cacheProvider = $this->getMockForAbstractClass('\Doctrine\Common\Cache\Cache');
        $this->encryptor     = $this->getMockForAbstractClass('\Trt\Doctrine\Cache\Encryptor\Encryptor');
    }

    /**
     * @test
     */
    public function itShouldDecryptAfterFetch()
    {
        $provider = new CacheProviderDecorator($this->cacheProvider, $this->encryptor);

        $this->encryptor->expects($this->once())
            ->method('decrypt')
            ->willReturn('decryptedData');

        $this->cacheProvider->expects($this->once())
            ->method('fetch')
            ->willReturn('encryptedData');

        $this->assertEquals('decryptedData', $provider->fetch('key'));
    }

    /**
     * @test
     */
    public function itShouldNotDecryptOnCacheMiss()
    {
        $provider = new CacheProviderDecorator($this->cacheProvider, $this->encryptor);

        $this->encryptor->expects($this->never())->method('decrypt');

        $this->cacheProvider->expects($this->once())
            ->method('fetch')
            ->willReturn(false);

        $this->assertEquals(false, $provider->fetch('key'));
    }

    /**
     * @test
     */
    public function itShouldEncryptBeforeSave()
    {
        $provider = new CacheProviderDecorator($this->cacheProvider, $this->encryptor);

        $this->encryptor->expects($this->once())
            ->method('encrypt')
            ->with($this->equalTo('data'))
            ->willReturn('encryptedData');

        $this->cacheProvider->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo('key'),
                $this->equalTo('encryptedData')
            );

        $provider->save('key', 'data');
    }

}
 