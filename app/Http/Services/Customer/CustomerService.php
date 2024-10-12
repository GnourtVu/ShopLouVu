<?php

namespace App\Http\Services\Customer;

use App\Models\Customer;

class CustomerService
{
    public function getAll()
    {
        return Customer::select('id', 'name', 'phone', 'email', 'role', 'point')->orderByDesc('role')->paginate(15);
    }
}
