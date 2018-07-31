<?php

namespace App\Http\Controllers\Api;

use App\Models\Sms;
use App\Traits\RedisTrait;
use App\Validates\SmsValidate;
use Illuminate\Http\Request;

class ThirdController extends ApiController
{
    use RedisTrait;

    public function sendSms(Request $request, SmsValidate $validate)
    {
        $request_data = $request->all();
        $rest_validate = $validate->storeValidate($request_data);
        if ($rest_validate['status'] === true) {
            $phone = $request_data['phone'];
            $code = $rest_validate['data']['sms_code'];
            (new \App\Handlers\Sms)->sendSms($phone, ['code' => $code]);
            Sms::create([
                'phone' => $phone,
                'type' => 'O',
                'code' => $code,
                'ip' => get_client_ip()
            ]);
            $this->setRedis('smsCode', $phone, $rest_validate['data']);
            return $this->success($rest_validate['data'], $rest_validate['message']);
        } else {
            return $this->failed($rest_validate['message']);
        }
    }
}
