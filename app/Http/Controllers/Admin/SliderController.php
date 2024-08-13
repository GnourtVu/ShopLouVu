<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\Sliderformrquest;
use App\Http\Services\Slider\SliderService;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }
    //Danh sach slider
    public function index()
    {
        return view('admin.sliders.list', [
            'title' => 'List Sliders',
            'sliders' => $this->sliderService->sliderList(),
        ]);
    }
    //Them moi slider
    public function create()
    {
        return view('admin.sliders.create', [
            'title' => 'Create Slider'
        ]);
    }
    public function store(Sliderformrquest $request)
    {
        $result = $this->sliderService->createSlider($request);
        if ($result) {
            return redirect('/admin/sliders/index');
        } else {
            return redirect()->back();
        }
    }
    //Xoa slider
    public function destroy(Request $request): JsonResponse
    {
        $result = $this->sliderService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Deleted successful'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Deleted failed'
            ]);
        }
    }
    //Cap nhat slider
    public function show(Slider $slider)
    {
        return view('admin.sliders.edit', [
            'title' => 'Update slider',
            'slider' => $slider
        ]);
    }
    public function edit(Sliderformrquest $request, Slider $slider)
    {
        $result = $this->sliderService->edit($request, $slider);
        if ($result) {
            return redirect('/admin/sliders/index');
        } else {
            return redirect()->back();
        }
    }
}
