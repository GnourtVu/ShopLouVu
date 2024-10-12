<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^0[0-9]{9}$/',
        ];

        // Kiểm tra nếu người dùng muốn đổi mật khẩu
        if ($this->has('change_password')) {
            $rules['password'] = 'required|min:6';
            $rules['passwordNew'] = 'required|min:6';
            $rules['passwordCf'] = 'required|same:passwordNew';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'phone.required' => 'Bạn chưa nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số.',
            'password.required' => 'Bạn phải nhập mật khẩu cũ.',
            'passwordNew.required' => 'Bạn chưa nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'passwordNew.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'passwordCf.required' => 'Bạn phải nhập lại mật khẩu mới.',
            'passwordCf.same' => 'Mật khẩu nhập lại không khớp.',
        ];
    }
}
