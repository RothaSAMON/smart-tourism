<?php
namespace App\Helpers;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelpers
{
    const CACHE_TAG = 'settings';
    public static function model()
    {
        return Setting::class;
    }

    public static function get($key)
    {
        if (app()->runningInConsole()) {
            return self::remember($key, function () use ($key) {
                return self::model()::get($key);
            });
        }
        return config('settings.' . $key) ?: null;
    }

    public static function set($key, $value)
    {
        self::model()::set($key, $value);

        return self::model()::get($key) ?: null;
    }

    public static function clearAllCache(): void
    {
        if (self::supportsTags()) {
            Cache::tags(self::CACHE_TAG)->flush();
        } else {
            Cache::flush();
        }
    }

    protected static function remember(string $key, callable $callback)
    {
        if (self::supportsTags()) {
            return Cache::tags(self::CACHE_TAG)->remember($key, now()->addDay(), $callback);
        }
        return Cache::remember($key, now()->addDay(), $callback);
    }

    public static function clearCache(string $key): void
    {
        if (self::supportsTags()) {
            Cache::tags(self::CACHE_TAG)->forget($key);
        } else {
            Cache::forget($key);
        }
    }

    protected static function supportsTags(): bool
    {
        return method_exists(Cache::getStore(), 'tags');
    }
}
