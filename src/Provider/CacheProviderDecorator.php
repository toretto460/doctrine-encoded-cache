<?php

namespace Trt\Doctrine\Cache\Provider;


use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;
use Trt\Doctrine\Cache\Encryptor\Encryptor;

class CacheProviderDecorator implements Cache
{
    /** @var CacheProvider  */
    protected $wrappedCacheProvider;

    /** @var Encryptor  */
    protected $encryptor;

    /**
     * @param Cache $cacheProvider
     * @param Encryptor $encryptor
     */
    public function __construct(Cache $cacheProvider, Encryptor $encryptor)
    {
        $this->wrappedCacheProvider = $cacheProvider;
        $this->encryptor = $encryptor;
    }

    /**
     * Fetches an entry from the cache and decrypt it.
     *
     * @param string $id The id of the cache entry to fetch.
     *
     * @return mixed The cached data or FALSE, if no cache entry exists for the given id.
     */
    public function fetch($id)
    {
        $data = $this->wrappedCacheProvider->fetch($id);

        return (false === $data) ? false : $this->encryptor->decrypt($data);
    }

    /**
     * Encrypt the data and put it into the cache.
     *
     * @param string $id       The cache id.
     * @param mixed  $data     The cache entry/data.
     * @param int    $lifeTime The cache lifetime.
     *                         If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return boolean TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function save($id, $data, $lifeTime = 0)
    {
        $data = $this->encryptor->encrypt($data);

        return $this->wrappedCacheProvider->save($id, $data, $lifeTime);
    }


    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id The cache id of the entry to check for.
     *
     * @return boolean TRUE if a cache entry exists for the given cache id, FALSE otherwise.
     */
    function contains($id)
    {
        return $this->wrappedCacheProvider->contains($id);
    }

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return boolean TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    function delete($id)
    {
        $this->wrappedCacheProvider->delete($id);
    }

    /**
     * Retrieves cached information from the data store.
     *
     * The server's statistics array has the following values:
     *
     * - <b>hits</b>
     * Number of keys that have been requested and found present.
     *
     * - <b>misses</b>
     * Number of items that have been requested and not found.
     *
     * - <b>uptime</b>
     * Time that the server is running.
     *
     * - <b>memory_usage</b>
     * Memory used by this server to store items.
     *
     * - <b>memory_available</b>
     * Memory allowed to use for storage.
     *
     * @since 2.2
     *
     * @return array|null An associative array with server's statistics if available, NULL otherwise.
     */
    function getStats()
    {
        return $this->wrappedCacheProvider->getStats();
    }
}