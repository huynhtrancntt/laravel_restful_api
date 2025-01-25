<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreCustomerRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(['I', 'B'])],
            'email' => ['required', 'email'],
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string', // Sửa thành snake_case
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute là trường bắt buộc.',
            'email' => ':attribute không hợp lệ.',
            'in' => ':attribute phải là một trong các giá trị sau: :values.',
            'string' => ':attribute phải là chuỗi ký tự.',
            // Các thông báo khác...
            'attributes' => [
                'name' => 'Tên',
                'type' => 'Loại',
                'email' => 'Email',
                'address' => 'Địa chỉ',
                'city' => 'Thành phố',
                'state' => 'Bang',
                'postal_code' => 'Mã bưu chính',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'postal_code' => $this->postalCode, // Chuyển từ camelCase sang snake_case
        ]);
    }

}
