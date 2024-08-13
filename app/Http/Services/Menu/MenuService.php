<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MenuService
{
    public function getParent()
    {
        return Menu::Where('parent_id', 0)->get();
    }
    public function show()
    {
        return Menu::select('name', 'id', 'thumb')->where('parent_id', 0)->orderbyDesc('id')->get();
    }
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }
    public function getAll()
    {
        return Menu::orderbyDesc('id')->paginate(20);
    }
    public function create($request, $menu)
    {
        try {
            $check = Menu::where('name', $request->input('name'))->first();
            if (!$check) {
                Menu::create([
                    'name' => (string) $request->input('name'),
                    'parent_id' => (int) $request->input('parent_id'),
                    'description' => (string) $request->input('description'),
                    'content' => (string) $request->input('content'),
                    'active' => (int) $request->input('active'),
                    'thumb' => (string) $request->input(''),
                    'slug' => Str::slug($request->input('name'), '-')
                ]);
                Session::flash('success', 'Create category successful');
                return true;
            }
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return false;
        }
    }
    public function destroy($request)
    {
        $id = $request->input('id');

        if (!$id) {
            // Xử lý khi id không được cung cấp
            return false;
        }

        $menu = Menu::where('id', $id)->first();

        if ($menu) {
            // Xóa mục với id hoặc tất cả các mục con
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }

    public function edit($menu, $request): bool
    {
        // try {
        //     $menu->fill($request->input());
        //     $menu->save();
        //     Session::flash('success', 'Update successful');
        // } catch (Exception $e) {
        //     Session::flash('error', $e->getMessage());
        // }

        if ($request->input('parent_id') != $menu->id) {
            $menu->parent_id = (int)$request->input('parent_id');
        }
        $menu->name = (string)$request->input('name');
        $menu->description = (string) $request->input('description');
        $menu->content = (string) $request->input('content');
        $menu->thumb = (string) $request->input('thumb');
        $menu->active = (int) $request->input('active');
        $menu->save();
        Session::flash('success', 'Update successful');
        return true;
    }
    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }
    public function getProducts($menu, $request)
    {
        if ($request) {
            $query = $menu->products()
                ->select('id', 'name', 'price', 'price_sale', 'thumb')
                ->where('active', 1);
        }

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }
        if ($request->input('price_range')) {
            switch ($request->input('price_range')) {
                case 'low_price':
                    $query->whereBetween('price', [100000, 199000]);
                    break;
                case 'medium_price':
                    $query->whereBetween('price', [200000, 299000]);
                    break;
                case 'high_price':
                    $query->Where('price', '>', 300000);
                    break;
            }
        }
        return  $query->orderByDesc('id')->paginate(8)->withQueryString();
    }
}
