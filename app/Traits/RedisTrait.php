<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RedisTrait
{
    protected $redisKeyType = [
        'demo' => 'demo_', // 示例_[xxx]
    ];

    protected function setRedis($redisKeyType, $key, $value)
    {
        Redis::set($this->redisKeyType[$redisKeyType] . $key, json_encode($value));
    }

    protected function getRedis($redisKeyType, $key)
    {
        return json_decode(Redis::get($this->redisKeyType[$redisKeyType] . $key), true);
    }
}
