<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class ReviewFormRequest extends FormRequest
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
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^0[0-9]{9}$/',
        ];
    }
    public function messages()
    {
        return [
            'rating.min' => "Bạn chưa đánh giá ",
            'content.required' => "Bạn chưa nhập nội dung",
            'email.required' => "Email không được bỏ trống",
            'phone.required' => "Bạn chưa nhập số điện thoại.",
            'phone.regex' => "Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số.",
        ];
    }
}
