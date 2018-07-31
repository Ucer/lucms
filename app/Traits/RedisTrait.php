<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

trait RedisTrait
{
    protected $redisKeyType = [
        'smsCode' => 'smsCode_', // 短信验证码
    ];

    protected function setRedis($redisKeyType,$key, $value)
    {
        Redis::set($this->redisKeyType[$redisKeyType].$key, json_encode($value));
    }

    protected function getRedis($redisKeyType,$key)
    {
        return json_decode(Redis::get($this->redisKeyType[$redisKeyType].$key));
    }
}
