<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

// hoặc
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }
    public function isValidPrice($request)
    {
        if ($request->input('price')  != 0 && $request->input('price_sale') != 0 && $request->input('price') <= $request->input('price_sale')) {
            Session::flash('error', 'Price sale must be smaller than price');
            return false;
        }
        if ($request->input('price_sale') != 0 && $request->input('price') == 0) {
            Session::flash('error', 'You must be enter price');
            return false;
        }
        return true;
    }
    public function create($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) {
            return false;
        }

        try {
            // Xử lý ảnh
            $data = $request->except('_token');

            if ($request->hasFile('image1')) {
                $file = $request->file('image1');
                $path = $file->store('uploads', 'public');
                $data['image1'] = '/storage/' . $path;
            }

            if ($request->hasFile('image2')) {
                $file = $request->file('image2');
                $path = $file->store('uploads', 'public');
                $data['image2'] = '/storage/' . $path;
            }

            if ($request->hasFile('image3')) {
                $file = $request->file('image3');
                $path = $file->store('uploads', 'public');
                $data['image3'] = '/storage/' . $path;
            }

            Product::create($data);

            Session::flash('success', 'Create product successful');
        } catch (\Exception $e) {
            Session::flash('error', 'Create product failed');
            Log::error($e->getMessage());
            return false;
        }

        return true;
    }

    public function get()
    {
        return Product::with('menu')
            ->orderByDesc('id')->paginate(20);
    }
    public function destroy($request)
    {
        $id = $request->input('id');
        if (!isset($id)) {
            return false;
        }
        $product = Product::where('id', $id)->first();
        if ($product) {
            return Product::where('id', $id)->delete();
        }
    }
    public function getProduct($request, $product): bool
    {
        try {
            // Xử lý ảnh
            $data = $request->input();

            if ($request->hasFile('image1')) {
                $file = $request->file('image1');
                $path = $file->store('uploads', 'public');
                $data['image1'] = '/storage/' . $path;
            }

            if ($request->hasFile('image2')) {
                $file = $request->file('image2');
                $path = $file->store('uploads', 'public');
                $data['image2'] = '/storage/' . $path;
            }

            if ($request->hasFile('image3')) {
                $file = $request->file('image3');
                $path = $file->store('uploads', 'public');
                $data['image3'] = '/storage/' . $path;
            }

            $product->fill($data);
            $product->save();

            Session::flash('success', 'Update successful');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return false;
        }

        return true;
    }
}
