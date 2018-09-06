<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemConfig;
use App\Traits\TableStatusTrait;
use App\Validates\SystemConfigValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SystemConfigsController extends AdminController
{
    use TableStatusTrait;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');
    }

    public function list(Request $request, SystemConfig $systemConfig)
    {
        $search_data = json_decode($request->get('search_data'), true);
        $flag = isset_and_not_empty($search_data, 'flag');
        if ($flag) {
            $systemConfig = $systemConfig->columnLike('flag', $flag);
        }
        $title = isset_and_not_empty($search_data, 'title');
        if ($title) {
            $systemConfig = $systemConfig->columnLike('title', $title);
        }
        $enable = isset_and_not_empty($search_data, 'enable');
        if ($enable) {
            $systemConfig = $systemConfig->enableSearch($enable);
        }
        $group = isset_and_not_empty($search_data, 'group');
        if ($group) {
            $systemConfig = $systemConfig->columnLike('system_config_group', $group);
        }
        $order_by = isset_and_not_empty($search_data, 'order_by');
        if ($order_by) {
            $order_by = explode(',', $order_by);
            $systemConfig = $systemConfig->orderBy($order_by[0], $order_by[1]);
        }

        return $this->success($systemConfig->get());
    }

    public function getGroup()
    {
        return $this->success([
            'group' => Config::get('lu.system_config_group_list'),
            'enable' => $this->getBaseStatus('system_configs', 'enable')
        ]);
    }

    public function show(Systemconfig $systemConfig)
    {
        return $this->success($systemConfig);
    }

    public function store(Request $request, SystemConfig $systemConfig, SystemConfigValidate $validate)
    {
        $insert_data = $request->all();
        $rest_validate = $validate->storeValidate($insert_data);

        if ($rest_validate['status'] === false) return $this->failed($rest_validate['message']);


        $res = $systemConfig->storeSystemConfig($insert_data);
        if ($res['status'] === true) return $this->message($res['message']);
        return $this->failed($res['message']);
    }


    public function update(Request $request, SystemConfig $systemConfig, SystemConfigValidate $validate)
    {
        $update_data = $request->all();
        $rest_validate = $validate->updateValidate($update_data, $systemConfig->id);

        if ($rest_validate['status'] === false) return $this->failed($rest_validate['message']);


        $res = $systemConfig->storeSystemConfig($update_data);
        if ($res['status'] === true) return $this->message($res['message']);
        return $this->failed($res['message']);
    }

    public function destroy(SystemConfig $systemConfig)
    {
        $systemConfig->delete();
        return $this->success([], '数据删除成功');
    }
}
