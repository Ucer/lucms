<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RedisTrait
{
    protected $redisKeyType = [
        'demo' => [
            'name' => 'demo_', // 示例_[xxx]
            'expiry_time' => 3600 * 365, // 过期时间[秒]
            'default_value' => ''
        ]
    ];

    protected function setRedis($redisKeyType, $key, $value)
    {
        Redis::set($this->redisKeyType[$redisKeyType]['name'] . $key, json_encode($value));
    }

    protected function setExRedis($redisKeyType, $key, $value, $expiry_time = 0)
    {
        $expiry_time = $expiry_time > 10 ?: $this->redisKeyType[$redisKeyType]['expiry_time'];
        Redis::setex($this->redisKeyType[$redisKeyType]['name'] . $key, $expiry_time, json_encode($value));
    }

    protected function getRedis($redisKeyType, $key)
    {
        $reidsKey = $this->redisKeyType[$redisKeyType];
        return json_decode(Redis::get($reidsKey['name'] . $key), true) ?: $reidsKey['default_value'];
    }
}
