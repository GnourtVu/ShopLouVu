<?php

namespace App\Http\Services\Slider;

use App\Models\Slider;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SliderService
{

    public function sliderList()
    {
        return Slider::orderBy("created_at", "desc")->get();
    }
    public function show()
    {
        return Slider::where('active', 1)->orderByDesc('sort_by')->get();
    }
    public function createSlider(Request $request): bool
    {
        if ($request) {
            try {
                $request->accepts('_token');
                Slider::create($request->all());
                Session::flash('success', 'Create slider successful');
            } catch (\Exception $e) {
                Session::flash('error', 'Create failed');
                Log::error($e->getMessage());
                return false;
            }
        }
        return true;
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if (isset($id)) {
            $slider = Slider::where('id', $id)->first();
            if ($slider) {
                return Slider::where('id', $slider->id)->delete();
            }
        }
    }
    public function edit($request, $slider)
    {
        try {
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success', 'Update slider successful');
        } catch (\Exception $e) {
            Session::flash('error', 'Update slider failed');
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
}
