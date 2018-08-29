<?php

namespace App\Http\Controllers\Api;

use App\Models\AdvertisementPosition;
use App\Traits\ExcelTrait;
use Illuminate\Http\Request;

class ExcelController extends ApiController
{
    use ExcelTrait;

    public function __construct()
    {

    }

    public function exportAdvertisementPosition(Request $request, AdvertisementPosition $advertisementPosition)
    {

        $search_data = json_decode($request->get('search_data'), true);
        $name = isset_and_not_empty($search_data, 'name');
        if ($name) {
            $advertisementPosition = $advertisementPosition->columnLike('name', $name);
        }
        $type = isset_and_not_empty($search_data, 'type');
        if ($type) {
            $advertisementPosition = $advertisementPosition->typeSearch($type);
        }
        $order_by = isset_and_not_empty($search_data, 'order_by');
        if ($order_by) {
            $order_by = explode(',', $order_by);
            $advertisementPosition = $advertisementPosition->orderBy($order_by[0], $order_by[1]);
        }
        $list = $advertisementPosition->get();
        $this->excelAdvertisementPosition($list);

    }

}
