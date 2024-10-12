<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'phone' => 'required|string|regex:/^0[0-9]{9}$/',
            'email' => 'required',
            'address' => 'required',
            'payment' => 'required',
            'province' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "Tên không được bỏ trống.",
            'phone.required' => "Bạn chưa nhập số điện thoại.",
            'phone.regex' => "Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số.",
            'email' => "Bạn chưa nhập email.",
            'address' => "Bạn chưa nhập địa chỉ.",
            'payment' => "Vui lòng chọn phương thức vận chuyển."
        ];
    }
}
