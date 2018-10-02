<?php

namespace App\Http\Controllers\Api;


use App\Handlers\FileuploadHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function avatarUpload(Request $request, FileuploadHandler $fileuploadHandler)
    {
        $file = $request->file('file');

        $rest_upload_image = $fileuploadHandler->uploadImage($file, Auth::id(), 300, 'avatars');
        if ($rest_upload_image['status'] === true) {
            return $this->success($rest_upload_image['data']);
        } else {
            return $this->failed($rest_upload_image['message']);
        }
    }

    public function wangUpload(Request $request, FileuploadHandler $fileuploadHandler)
    {
        $file = $request->file('file');

        $rest_upload_image = $fileuploadHandler->uploadImage($file, Auth::id(), 800, 'editors');
        if ($rest_upload_image['status'] === true) {
            return $this->success($rest_upload_image['data']);
        } else {
            return $this->failed($rest_upload_image['message']);
        }

    }

    public function advertisementUpload(Request $request, FileuploadHandler $fileuploadHandler)
    {
        $file = $request->file('file');

        $rest_upload_image = $fileuploadHandler->uploadImage($file, Auth::id(), 800, 'advertisements');
        if ($rest_upload_image['status'] === true) {
            return $this->success($rest_upload_image['data']);
        } else {
            return $this->failed($rest_upload_image['message']);
        }

    }

    public function tmpUpload(Request $request, FileuploadHandler $fileuploadHandler)
    {
        $file = $request->file('file');

        $rest_upload_image = $fileuploadHandler->uploadImage($file, Auth::id(), $request->post('max_width'), 'tmp');
        if ($rest_upload_image['status'] === true) {
            return $this->success($rest_upload_image['data']);
        } else {
            return $this->failed($rest_upload_image['message']);
        }

    }

    public function carouselUpload(Request $request, FileuploadHandler $fileuploadHandler)
    {
        $file = $request->file('file');

        $rest_upload_image = $fileuploadHandler->uploadImage($file, Auth::id(), $request->post('max_width'), 'carousels');
        if ($rest_upload_image['status'] === true) {
            return $this->success($rest_upload_image['data']);
        } else {
            return $this->failed($rest_upload_image['message']);
        }

    }


    public function newVersionUpload(Request $request, FileuploadHandler $fileuploadHandler)
    {
        $file = $request->file('file');

        $rest_upload_image = $fileuploadHandler->uploadImage($file, Auth::id(), 0, 'versions');
        if ($rest_upload_image['status'] === true) {
            return $this->success($rest_upload_image['data']);
        } else {
            return $this->failed($rest_upload_image['message']);
        }

    }
}
