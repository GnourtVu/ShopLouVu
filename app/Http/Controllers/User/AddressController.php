<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function getDistricts($provinceId)
    {
        $districts = $this->callApiToGetDistricts($provinceId); // Gọi API để lấy danh sách quận/huyện
        return response()->json($districts);
    }

    public function getWards($districtId)
    {
        $wards = $this->callApiToGetWards($districtId); // Gọi API để lấy danh sách phường/xã
        return response()->json($wards);
    }
}
