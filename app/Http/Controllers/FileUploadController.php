<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class FileUploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
        if(!$request->hasFile('image')){
            return response()->error('Image file required', 401);
        }
        $file = $request->file('image');
        $name = time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());
        $filePath = 'public/' . $name;
        $fileContent = null;

        $fileContent = file_get_contents($file);

        $result = Storage::disk('local')->put($filePath, $fileContent);
        
        if (!$result) {
            return response()->error('Image could not be uploaded', 401);
        }
        
        $url = Storage::url($filePath);
        
        $response = [
            'file' => env('IMG_URL').$url,
        ];

        return response()->success($response, 'Image uploaded successfully', 200);
    }
}
