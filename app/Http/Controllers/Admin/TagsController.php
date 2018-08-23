<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\TagCollection;
use App\Models\Tag;
use App\Validates\TagValidate;
use Illuminate\Http\Request;

class TagsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');
    }

    public function tagList(Request $request, Tag $tag)
    {
        $per_page = $request->get('per_page', 10);
        $search_data = json_decode($request->get('search_data'), true);
        $name = isset_and_not_empty($search_data, 'name');
        if ($name) {
            $tag = $tag->columnLike('name', $name);
        }

        $order_by = isset_and_not_empty($search_data, 'order_by');
        if ($order_by) {
            $order_by = explode(',', $order_by);
            $tag = $tag->orderBy($order_by[0], $order_by[1]);
        }

        return new TagCollection($tag->paginate($per_page));
    }

    public function show(Tag $tag)
    {
        return $this->success($tag);
    }

    public function addEditTag(Request $request, Tag $tag, TagValidate $validate)
    {
        $data = $request->all();
        $tag_id = $request->post('id', 0);


        if ($tag_id > 0) {
            $tag = $tag->findOrFail($tag_id);
            $rest_validate = $validate->updateValidate($data, $tag_id);
        } else {
            $rest_validate = $validate->storeValidate($data);
        }
        if ($rest_validate['status'] === false) return $this->failed($rest_validate['message']);

        $res = $tag->saveData($data);

        if ($res) return $this->message('操作成功');
        return $this->failed('内部错误');

    }

    public function destroy(Tag $tag, TagValidate $validate)
    {
        if (!$tag) return $this->failed('找不到数据', 404);
        $rest_destroy_validate = $validate->destroyValidate($tag);
        if ($rest_destroy_validate['status'] === true) {
            $rest_destroy = $tag->destroyTag();
            if ($rest_destroy['status'] === true) return $this->message($rest_destroy['message']);
            return $this->failed($rest_destroy['message'], 500);
        } else {
            return $this->failed($rest_destroy_validate['message']);
        }
    }
}
