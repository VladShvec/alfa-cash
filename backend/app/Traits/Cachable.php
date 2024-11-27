<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait Cachable
{
    /**
     *
     * @param string $key
     * @param \Closure $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, \Closure $callback, int $ttl = null)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    public function getByKey(string $key)
    {
        return Cache::get($key);
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }
}
