<?php

namespace App\Http\Controllers\Admin;

use App\Models\Carousel;
use Illuminate\Http\Request;

class NewsController extends AdminController
{

    public function carousels(Carousel $carousel)
    {
        $carousel = $carousel->orderBy('weight', 'asc');
        return $this->success($carousel->get());
    }

    public function showCarousels($id, Carousel $carousel)
    {
        $m_carsousel = $carousel->findOrFail($id);
        return $this->success($m_carsousel);
    }

    public function storeCarousel(Request $request, Carousel $carousel)
    {
        $insert_data = $request->all();
        if (isset($insert_data['cover_image']['attachment_id'])) {
            $insert_data['cover_image'] = $insert_data['cover_image']['attachment_id'];
        } else {
            return $this->failed('必须上传图片');
        }
        if(!$insert_data['url']) $insert_data['url'] = '';
        if(!$insert_data['description']) $insert_data['description'] = '';

        $res = $carousel->storeCarousel($insert_data);
        if ($res['status'] === true) return $this->message($res['message']);
        return $this->failed($res['message']);
    }


    public function updateCarousel(Request $request, Carousel $carousel, $id)
    {
        $insert_data = $request->all();
        if (isset($insert_data['cover_image']['attachment_id'])) {
            $insert_data['cover_image'] = $insert_data['cover_image']['attachment_id'];
        } else {
            return $this->failed('必须上传图片');
        }
        $m_carousel = $carousel->findOrFail($id);

        if(!$insert_data['url']) $insert_data['url'] = '';
        if(!$insert_data['description']) $insert_data['description'] = '';
        $res = $carousel->updateCarousel($insert_data, $m_carousel);
        if ($res['status'] === true) return $this->message($res['message']);
        return $this->failed($res['message']);
    }

    public function destroyCarousel($id, Carousel $carousel)
    {
        $m_carousel = $carousel->findOrFail($id);
        $res = $carousel->destroyCarousel($m_carousel);
        if ($res['status'] === true) return $this->message($res['message']);
        return $this->failed($res['message']);
    }

}
