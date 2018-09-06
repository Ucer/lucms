<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SystemConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        // 插入到数据库中
        \App\Models\SystemConfig::insert([
            [
                'flag' => 'direct_recommend_one_people_get_money',
                'title' => '直推合伙人得钱',
                'system_config_group' => 'money_send_rule',
                'value' => '20000',
                'description' => '每直推一个合伙人可得金钱「元」',
                'weight' => 10,
                'enable' => 'T',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'flag' => 'qyjxs_recommend_one_people_get_money',
                'title' => '区域经销商下面的人推荐合伙人得钱',
                'system_config_group' => 'money_send_rule',
                'value' => '1000',
                'description' => '区域经销商下面的人每推荐一个合伙人上级可得钱「元」',
                'weight' => 10,
                'enable' => 'T',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'flag' => 'md_recommend_one_people_get_money',
                'title' => '门店下面的人推荐合伙人得钱',
                'system_config_group' => 'money_send_rule',
                'value' => '1000',
                'description' => '门店下面的人每推荐一个合伙人上级可得钱「元」',
                'weight' => 10,
                'enable' => 'T',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'flag' => 'dz_recommend_one_people_get_money',
                'title' => '杜总下面的人推荐合伙人得钱',
                'system_config_group' => 'money_send_rule',
                'value' => '100',
                'description' => '杜总下面的人每推荐一个合伙人上级可得钱「元」',
                'weight' => 10,
                'enable' => 'T',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'flag' => 'direct_recommend_one_people_get_integral',
                'title' => '直推合伙人得积分',
                'system_config_group' => 'integral_rule',
                'value' => '1',
                'description' => '每直推一个合伙人可得积分「个」',
                'weight' => 10,
                'enable' => 'T',
                'created_at' => $now,
                'updated_at' => $now
            ]

        ]);
    }
}
