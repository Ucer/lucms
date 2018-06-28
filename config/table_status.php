<?php

return [
    'users' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
        'is_admin' => ['F' => '否', 'T' => '是'],
    ],
    'attachments' => [
        'enable' => ['F' => '禁用', 'T' => '启用'],
        'use_status' => ['F' => '未使用', 'T' => '使用中'],
        'type' => ['avatars' => '头像', 'identifies' => '认证图片', 'advertisements' => '广告', 'editors' => '编辑器', 'others' => '其它'],
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
    ]
];
