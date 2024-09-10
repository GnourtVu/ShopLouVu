<?php

namespace App\Http\Services\Discount;

use App\Models\Discount;
use Exception;
use Illuminate\Support\Facades\Session;

class DiscountService
{
    public function create($request, $discount)
    {
        try {
            $check = Discount::where('name', $request->input('name'))->first();
            if (!$check) {
                Discount::create([
                    'name' => (string)$request->input('name'),
                    'discount' => (float)$request->input('discount'),
                    'thumb' => (string)$request->input('thumb'),
                    'code' => (string)$request->input('code'),
                    'active' => (int)$request->input('active'),
                ]);
                Session::flash('success', 'Create discount successful');
                return true;
            }
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return false;
        }
    }
    public function getAll()
    {
        return Discount::select('id', 'name', 'discount', 'active', 'code', 'thumb')->orderByDesc('id')->get();
    }
    public function destroy($request)
    {
        $id = $request->input('id');

        if (!$id) {
            return false;
        }
        $discount = Discount::where('id', $id)->first();
        if ($discount) {
            return Discount::where('id', $id)->delete();
        }
        return false;
    }
    public function update($discount, $request)
    {
        $discount->name = (string)$request->input('name');
        $discount->discount = (string) $request->input('discount');
        $discount->code = (string) $request->input('code');
        $discount->thumb = (string) $request->input('thumb');
        $discount->active = (int) $request->input('active');
        $discount->save();
        Session::flash('success', 'Update successful');
        return true;
    }
}
