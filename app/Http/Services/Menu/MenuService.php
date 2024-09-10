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
        return Menu::select('name', 'id', 'thumb', 'slug')->where('parent_id', 0)->orderbyDesc('id')->get();
    }
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }
    public function getBySlug($slug)
    {
        return Menu::where('slug', $slug)->first();
    }

    public function getAll()
    {
        return Menu::orderbyDesc('id')->get();
    }
    public function create($request, $menu)
    {
        try {
            // Kiểm tra trùng lặp danh mục con cùng tên dưới cùng một danh mục cha
            $check = Menu::where('name', $request->input('name'))
                ->where('parent_id', $request->input('parent_id'))
                ->first();

            if (!$check) {
                Menu::create([
                    'name' => (string) $request->input('name'),
                    'parent_id' => (int) $request->input('parent_id'),
                    'description' => (string) $request->input('description'),
                    'content' => (string) $request->input('content'),
                    'active' => (int) $request->input('active'),
                    'thumb' => (string) $request->input('thumb'),
                    'slug' => Str::slug($request->input('name') . '-' . Str::slug($request->input('parent_id')), '-')
                ]);
                Session::flash('success', 'Create category successful');
                return true;
            } else {
                // Nếu danh mục đã tồn tại dưới cùng danh mục cha
                Session::flash('error', 'Category with this name already exists under the same parent.');
                return false;
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

    public function edit($menu, $request)
    {
        $newSlug = Str::slug($request->input('name'));

        // Kiểm tra xem slug mới có trùng với slug hiện tại không
        if ($menu->slug !== $newSlug) {
            // Kiểm tra xem slug đã tồn tại hay chưa
            $existingMenu = Menu::where('slug', $newSlug)->first();

            // Nếu slug đã tồn tại, bạn có thể thêm số vào để tạo slug duy nhất
            if ($existingMenu) {
                $i = 1;
                while ($existingMenu) {
                    $newSlug = Str::slug($request->input('name') . '-' . $i);
                    $existingMenu = Menu::where('slug', $newSlug)->first();
                    $i++;
                }
            }
        }

        // Cập nhật danh mục
        $menu->name = $request->input('name');
        $menu->slug = $newSlug;
        $menu->save();

        return redirect('/admin/menu/list');
    }

    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }
    public function getmainProducts($request)
    {
        $query = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);
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
        return  $query->orderByDesc('id')->paginate(16)->withQueryString();
    }

    public function getProducts($menu, $request)
    {
        // Lấy tất cả các id của danh mục con (bao gồm danh mục gốc)
        $categoryIds = $this->getAllCategoryIds($menu);

        // Truy vấn sản phẩm dựa trên danh sách id vừa thu thập được
        $query = Product::select('id', 'name', 'price', 'price_sale', 'thumb', 'image1', 'image2', 'image3')
            ->where('active', 1)
            ->whereIn('menu_id', $categoryIds);

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

        return $query->orderByDesc('id')->paginate(12)->withQueryString();
    }

    private function getAllCategoryIds($menu)
    {
        // Lấy tất cả các id của danh mục con và đệ quy cho các danh mục con của nó
        $ids = [$menu->id];
        foreach ($menu->children as $child) {
            $ids = array_merge($ids, $this->getAllCategoryIds($child));
        }
        return $ids;
    }
}
