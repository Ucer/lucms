<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMessage;

class StatisticsController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');

    }

    public function base()
    {
        $m_admin_message = new AdminMessage();

        $return = [
            'unread_message' => $m_admin_message->where('status', 'U')->count(),
        ];
        return $this->success($return);
    }


}
