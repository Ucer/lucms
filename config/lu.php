<?php

return [
    'demo' => 'demo',
    'system_config_type_list' => [
        'input' => ['title' => '字符', 'desc' => 'input[type=text]'],
        'number' => ['title' => '数字', 'desc' => 'input[type=number]'],
        'textarea' => ['title' => '文本', 'desc' => 'textarea框'],
        'enumeration' => ['title' => '枚举', 'desc' => 'key:value->写入item 配置值为默认值 下拉选择框,一行代表一项'],
        'array' => ['title' => '数组', 'desc' => 'value,value1 多个以逗号分隔,'],
    ],
    'system_config_group_list' => [
        'basic' => ['title' => '基本配置', 'icon' => 'gear', 'desc' => ''],
        'content' => ['title' => '内容配置', 'icon' => 'tasks', 'desc' => ''],
        'user' => ['title' => '用户配置', 'icon' => 'user', 'desc' => ''],
        'system' => ['title' => '系统配置', 'icon' => 'windows', 'desc' => ''],
    ],
];
