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
            $request->except('_token');
            Product::create($request->all());
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
            ->orderByDesc('id')->paginate(8);
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
            $product->fill($request->input());
            $product->save();
            Session::flash('success', 'Update successful');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }
}
