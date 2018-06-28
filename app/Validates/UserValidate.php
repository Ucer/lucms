<?php

namespace App\Validates;

use Illuminate\Support\Facades\Validator;

class  UserValidate extends Validate
{
    protected $message = '操作成功';
    protected $data = [];

    public function storeValidate($request_data)
    {
        $rules = [
            'name' => 'required|between:3,50',
        ];
        $rest_validate = $this->validate($request_data, $rules);
        if ($rest_validate === true) {
            return $this->succeed($this->data,$this->message);
        } else {
            $this->message = $rest_validate;
            return $this->failed($this->message);
        }

    }

    protected function validate($request_data, $rules)
    {
        $message = [
            'name.required' => '昵称不能为空',
            'name.between' => '昵称只能在:min-:max个字符范围',
        ];
        $validator = Validator::make($request_data, $rules, $message);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        return true;
    }
}
