<?php

namespace App\Traits;


use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    protected $cacheKeyType = [
        'smsCode' => 'smsCode_', // 短信验证码 _[18313852226]
    ];

    protected function cachePut($cacheKeyType, $key, $value, $expiredAt)
    {
        $cacheKey = $this->cacheKeyType[$cacheKeyType] . $key;
        Cache::put($cacheKey, $value, $expiredAt);
        return $cacheKey;
    }

    protected function cacheGet($cacheKey)
    {
        return Cache::get($cacheKey);
    }

}
