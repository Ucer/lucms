<?php

namespace App\Http\Controllers\Admin\Traits;

trait SystemConfigTrait
{
    /**
     * 拆分枚举类型配置项
     * @param $str item字段值
     */
    public function parsItem($str)
    {
        if (empty($str)) {
            return [];
        }
        $str = str_replace(['：', '：', '：',"\r\n","\n"], [':', ':', ':','',''], $str);
        $arr = explode(",", $str);
        $value = [];
        foreach ($arr as $k => $v) {
            if (strpos($v, ':')) {
                list($a, $b) = explode(':', $v);
                $value[$a] = $b;
            } else {
                $value = $arr;
            }
        }
        return $value;
    }

    /**
     * 拆分数组类型配置项
     * @param $str value字段值
     */
    public function parsItemArr($str)
    {
        if (empty($str)) {
            return [];
        }
        return str_replace([',', '，', '，'], "\r\n", $str);
    }
}
