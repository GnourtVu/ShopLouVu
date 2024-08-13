<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\UploadService;

class UploadController extends Controller
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'parent_id' => 'required|integer',
        //     'price' => 'required|numeric',
        //     'price_sale' => 'required|numeric',
        //     'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);
        $url = $this->uploadService->store($request);
        if ($url != false) {
            return response()->json([
                'error' => false,
                'url' => $url
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    }
}
