<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Customer\CustomerService;
use App\Models\Message;

class CustomerController extends Controller
{
    //
    protected $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    public function listCustomer()
    {
        $messages = Message::select('email', 'content')->orderByDesc('id')->get();
        $msCount = Message::count();
        $listCustomer = $this->customerService->getAll();
        return view('admin.customers.list', [
            'title' => 'List customer',
            'messages' => $messages,
            'msCount' => $msCount,
            'listCustomer' => $listCustomer,
        ]);
    }
}
