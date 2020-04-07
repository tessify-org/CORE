<?php

namespace Tessify\Core\Http\Controllers\Api;

use Uploader;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Profile\UploadAvatarRequest;
use Tessify\Core\Http\Requests\Api\Profile\UploadHeaderImageRequest;

class ProfileController extends Controller
{
    public function postUploadAvatar(UploadAvatarRequest $request)
    {
        $user = auth()->user();
        $user->avatar_url = Uploader::upload($request->file("avatar"), "users/avatars");
        $user->save();

        return response()->json([
            "status" => "success",
            "image_url" => asset($user->avatar_url)
        ]);
    }   

    public function postUploadHeaderImage(UploadHeaderImageRequest $request)
    {
        $user = auth()->user();
        $user->header_bg_url = Uploader::upload($request->file("header_image"), "users/headers");
        $user->save();

        return response()->json([
            "status" => "success",
            "image_url" => asset($user->header_bg_url),
        ]);
    }
}