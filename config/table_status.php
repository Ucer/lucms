<?php

return [
    'users' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
        'is_admin' => ['F' => '否', 'T' => '是'],
    ],
    'attachments' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
        'use_status' => ['F' => '未使用', 'T' => '使用中'],
        'type' => ['avatars' => '头像', 'advertisements' => '广告', 'editors' => '编辑器', 'tmp' => '临时图片'],
        'storage_position' => ['local' => '本地', 'oss' => '啊里云 oss'],
    ],
    'advertisement_positions' => [
        'type' => ['default' => '普通广告位', 'model' => '模型跳转广告位', 'spa' => '单页面广告位'],
    ],
    'advertisements' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
    ],
    'articles' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
        'recommend' => ['F' => '不推荐', 'T' => '推荐'],
        'top' => ['F' => '不置顶', 'T' => '置顶'],
    ],
    'ip_filters' => [
        'type' => ['white' => '白名单', 'black' => '黑名单'],
    ],
    'alipay_notifies' => [
        'model_type' => ['undefined' => '未定义表', 'pay_test' => '支付测试']
    ],
    'pay_notify_raws' => [
        'model_type' => ['ali_charge' => '支付宝通知', 'wx_charge' => '微信支付通知', 'cmb_charge' => '招商支付通知']
    ],
    'system_configs' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
    ],
    'logs' => [
        'type' => ['C' => '添加', 'U' => '更新', 'R' => '读取', 'D' => '删除', 'L' => '登录', 'O' => '其它'],
        'table_name' => [
            'users' => '用户表', 'attachments' => '附件表', 'roles' => '角色表', 'permissions' => '权限表',
//            'advertisement_positions' => '广告位表', 'advertisements' => '广告表', 'categories' => '分类表', 'tags' => '标签表',
//            'articles' => '文章表', 'ip_filters' => 'ip 过滤表', 'alipay_notifies' => '支付宝异步通知表', 'pay_notify_raws' => '支付异步通知数据源表',
//            'system_configs' => '系统配置表'
        ],
    ]
];
