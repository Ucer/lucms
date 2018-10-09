<?php

namespace App\Http\Controllers\Admin;


use App\Http\Resources\CommonCollection;
use App\Models\ApiMessage;
use App\Models\User;
use App\Validates\ApiMessageValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiMessagesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');
    }

    public function list(Request $request, ApiMessage $apiMessage)
    {
        $per_page = $request->get('per_page', 10);
        $search_data = json_decode($request->get('search_data'), true);

        $phone = isset_and_not_empty($search_data, 'phone');
        if ($phone) {
            $user_ids = User::where('phone', 'like', '%' . $phone . '%')->pluck('id')->toArray();
            $apiMessage = $apiMessage->columnInSearch('user_id', $user_ids);
        }

        $status = isset_and_not_empty($search_data, 'status');
        if ($status) {
            $apiMessage = $apiMessage->columnEqualSearch('status', $status);
        }

        $type = isset_and_not_empty($search_data, 'type');
        if ($type) {
            $apiMessage = $apiMessage->columnEqualSearch('type', $type);
        }

        $order_by = isset_and_not_empty($search_data, 'order_by');
        if ($order_by) {
            $order_by = explode(',', $order_by);
            $apiMessage = $apiMessage->orderBy($order_by[0], $order_by[1]);
        }
        return new CommonCollection($apiMessage->with('user')->paginate($per_page));
    }

    public function userSearch($phone, User $user)
    {
        return $this->success($user->enable()->columnLike('phone', '%' . $phone)->select('id', 'name', 'phone')->get());
    }

    public function store(Request $request, ApiMessage $apiMessage, ApiMessageValidate $validate)
    {
        $data = $request->all();
        if (!$data['url']) {
            $data['url'] = '';
        }
        $is_send_to_all = true;
        if ($data['users']) {
            $is_send_to_all = false;
        } else {
            unset($data['users']);
        }
        $rest_validate = $validate->storeValidate($data);
        if ($rest_validate['status'] === true) {
            $admin_id = Auth::id();
            if ($is_send_to_all) {
                $apiMessage->allMessage($data['title'], $data['content'], $admin_id, $data['url'], $data['is_alert_at_home'], $data['type']);
            } else {
                $date = date('Y-m-d H:i:s');

                foreach ($data['users'] as $user_id) {
                    $insert_data[] = [
                        'user_id' => $user_id,
                        'admin_id' => $admin_id,
                        'type' => $data['type'],
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'url' => $data['url'],
                        'is_alert_at_home' => $data['is_alert_at_home'],
                        'created_at' => $date
                    ];

                }
                $apiMessage->manyMessage($insert_data);
            }
            return $this->message('消息发送成功');
        } else {
            return $this->failed($rest_validate['message']);
        }
    }


}
