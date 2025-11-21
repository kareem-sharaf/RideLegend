<?php

namespace App\Infrastructure\Cache;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache TTL constants
     */
    public const TTL_SHORT = 300; // 5 minutes
    public const TTL_MEDIUM = 3600; // 1 hour
    public const TTL_LONG = 86400; // 24 hours
    public const TTL_VERY_LONG = 604800; // 7 days

    /**
     * Get or remember cache value
     */
    public function remember(string $key, int $ttl, callable $callback): mixed
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Get cache value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    /**
     * Put value in cache
     */
    public function put(string $key, mixed $value, int $ttl): bool
    {
        return Cache::put($key, $value, $ttl);
    }

    /**
     * Forget cache key
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Clear cache by tag (if supported)
     */
    public function clearTag(string $tag): void
    {
        if (method_exists(Cache::getStore(), 'tags')) {
            Cache::tags($tag)->flush();
        }
    }

    /**
     * Generate cache key
     */
    public function key(string $prefix, ...$params): string
    {
        $params = array_map(fn($param) => is_object($param) ? get_class($param) : (string) $param, $params);
        return $prefix . ':' . implode(':', $params);
    }
}
