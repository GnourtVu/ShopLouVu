<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

// hoặc
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }
    public function isValidPrice($request)
    {
        if ($request->input('price')  != 0 && $request->input('price_sale') != 0 && $request->input('price') < $request->input('price_sale')) {
            Session::flash('error', 'Price sale must be smaller or equal than price');
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
            $data = $request->except('_token', 'sizes', 'qty', 'colors'); // Loại bỏ '_token' và 'sizes' khỏi data chính
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $path = $file->store('uploads', 'public');
                $data['thumb'] = '/storage/' . $path;
            }

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

            // Tính tổng số lượng của các size
            $totalQty = 0;
            $product = Product::create($data);
            if ($request->has('qty')) {
                foreach ($request->input('qty') as $sizeId => $colors) {
                    foreach ($colors as $colorId => $qty) {
                        if ($qty > 0) {
                            // Lưu vào bảng product_vars
                            DB::table('product_vars')->insert([
                                'product_id' => $product->id,
                                'size_id' => $sizeId,
                                'color_id' => $colorId,
                                'qty' => $qty,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            // Cộng dồn số lượng
                            $totalQty += $qty;
                        }
                    }
                }
            }

            // Cập nhật qty_stock cho sản phẩm
            $product->qty_stock = $totalQty;
            $product->save();
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
    public function getProduct($request, Product $product): bool
    {
        $isValidPrice = $this->isValidPrice($request);
        if (!$isValidPrice) {
            return false;
        }

        try {
            // Lấy dữ liệu từ request và loại bỏ '_token', 'sizes', 'qty', 'colors' ra khỏi data chính
            $data = $request->except('_token', 'sizes', 'qty', 'colors');

            // Xử lý cập nhật ảnh nếu có file mới
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $path = $file->store('uploads', 'public');
                $data['thumb'] = '/storage/' . $path;
            }

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

            // Cập nhật sản phẩm chính
            $product->update($data);

            // Tính tổng số lượng của các size và màu
            $totalQty = 0;
            $productVarsData = [];

            if ($request->has('qty')) {
                foreach ($request->input('qty') as $sizeId => $colors) {
                    foreach ($colors as $colorId => $qty) {
                        if ($qty > 0) {
                            // Lưu vào mảng để chèn vào bảng product_vars
                            $productVarsData[] = [
                                'product_id' => $product->id,
                                'size_id' => $sizeId,
                                'color_id' => $colorId,
                                'qty' => $qty,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                            // Cộng dồn số lượng
                            $totalQty += $qty;
                        }
                    }
                }
            }

            // Xóa các size cũ hiện có trong bảng product_vars của sản phẩm này
            DB::table('product_vars')->where('product_id', $product->id)->delete();

            // Lưu thông tin kích thước và màu sắc mới vào bảng product_vars
            if (!empty($productVarsData)) {
                DB::table('product_vars')->insert($productVarsData);
            }

            // Cập nhật tổng số lượng vào thuộc tính qty_stock của bảng products
            $product->qty_stock = $totalQty;
            $product->save();

            Session::flash('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Session::flash('error', 'Update product failed');
            Log::error($e->getMessage());
            return false;
        }

        return true;
    }
}
