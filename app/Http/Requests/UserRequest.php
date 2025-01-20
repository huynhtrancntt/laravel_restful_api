<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->route()->user;

        // Quy tắc email động
        $emailRule = 'required|email|unique:users';
        if ($id) {

            $emailRule = $emailRule . ',email,' . $id;
            $name = $this -> name;
            $email = $this -> email;
            $password = $this ->password;
            $rules = [];
            if ($name) {
                $rules['name'] = 'required|string|max:255';
            }
            if ($email) {
                $rules['email'] = $emailRule;
            }
            if ($password) {
                $rules['password'] = 'required|min:6';
            }
            return $rules;
        }

        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => 'required|min:6', // `confirmed` sẽ yêu cầu có trường `password_confirmation`
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên người dùng',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
        ];
    }
}
