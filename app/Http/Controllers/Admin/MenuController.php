<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }
    // Danh sách danh mục
    public function list()
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        return view('admin.menus.list', [
            'title' => 'List Category',
            'messages' => $messages,
            'msCount' => $msCount,
            'menus' => $this->menuService->getAll()
        ]);
    }
    // Hiện form danh mục
    public function create()
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        return view('admin.menus.add', [
            'title' => 'Add category',
            'messages' => $messages,
            'msCount' => $msCount,
            'menus' => $this->menuService->getMenu()
        ]);
    }
    //Thêm mới danh mục
    public function store(CreateFormRequest $request, Menu $menu)
    {
        $result = $this->menuService->create($request, $menu);
        if ($result) {
            return redirect('/admin/menu/list')->with('success', 'Create successful');
        } else {
            return redirect()->back()->with('error', 'Failed create');
        }
    }
    //Xoá danh mục 
    public function destroy(Request $request): JsonResponse
    {
        $result = $this->menuService->destroy($request);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Deleted successfully',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Delete failed',
        ], 400);
    }

    //Sửa danh mục
    public function show(Menu $menu)
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        return view('admin.menus.edit', [
            'title' => 'Edit category : ' . $menu->name,
            'menu' => $menu,
            'messages' => $messages,
            'msCount' => $msCount,
            'menus' => $this->menuService->getMenu()
        ]);
    }
    public function edit(Menu $menu, CreateFormRequest $request)
    {
        $this->menuService->edit($menu, $request);
        return redirect('/admin/menu/list');
    }
}
