<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 6/10/15
 * Time: 1:20 PM
 */

namespace Clickbus\Cache;

use Redis;

class CacheService
{

    protected $cache;

    public function __construct(Redis $cache)
    {
        $this->cache = $cache;
        $serializer = defined('Redis::SERIALIZER_IGBINARY') ? \Redis::SERIALIZER_IGBINARY : \Redis::SERIALIZER_PHP;
        $this->cache->setOption(\Redis::OPT_SERIALIZER, $serializer);
    }

    public function get($key)
    {
        return $this->cache->get($key);
    }

    public function has($key)
    {
        return $this->cache->exists($key);
    }

    public function save($key, $data, $minutes = 60)
    {
        $time = $minutes * 60;
        return $this->cache->setex($key, $time, $data);
    }
} 