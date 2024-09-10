<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\CreateFormRequest;
use App\Http\Services\Discount\DiscountService;
use App\Models\Discount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    //
    protected DiscountService $discountService;
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }
    public function index()
    {
        return view('admin.discounts.add', [
            'title' => 'Add discount',
        ]);
    }
    public function store(CreateFormRequest $request, Discount $discount)
    {
        $result = $this->discountService->create($request, $discount);
        if ($result) {
            return redirect('admin/discounts/list');
        } else {
            return redirect()->back();
        }
    }
    public function show()
    {
        $discounts = $this->discountService->getAll();
        return view('admin.discounts.list', [
            'title' => 'List discount',
            'discounts' => $discounts
        ]);
    }
    public function destroy(Request $request): JsonResponse
    {
        $result = $this->discountService->destroy($request);
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
    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', [
            'title' => 'Edit discount',
            'discount' => $discount
        ]);
    }
    public function update(Discount $discount, CreateFormRequest $request)
    {
        $this->discountService->update($discount, $request);
        return redirect('admin/discounts/list');
    }
}
