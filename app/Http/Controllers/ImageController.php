<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $uploaded = $this->cloudinary->uploadApi()->upload(
            $request->file('image')->getRealPath(),
            ['folder' => 'recipes-upload']
        );

        return response()->json([
            'url'       => $uploaded['secure_url'],
            'public_id' => $uploaded['public_id'],
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'public_id' => 'required|string',
        ]);

        $result = $this->cloudinary->uploadApi()->destroy($request->public_id);

        return response()->json([
            'status' => 'deleted',
            'result' => $result,
        ]);
    }
}
