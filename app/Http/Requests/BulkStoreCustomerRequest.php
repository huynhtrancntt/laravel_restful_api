<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreCustomerRequest extends FormRequest
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
            'customers.*.name' => ['required', 'string'],
            'customers.*.type' => ['required', Rule::in(['I', 'B'])],
            'customers.*.email' => ['required', 'email'],
            'customers.*.address' => 'required|string',
            'customers.*.city' => 'required|string',
            'customers.*.state' => 'required|string',
            'customers.*.postal_code' => 'required|string', // Sửa thành snake_case
        ];
    }

    /**
     * Custom error messages for the fields.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute là trường bắt buộc.',
            'email' => ':attribute không hợp lệ.',
            'in' => ':attribute phải là một trong các giá trị sau: :values.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'attributes' => [
                'customers.*.name' => 'Tên',
                'customers.*.type' => 'Loại',
                'customers.*.email' => 'Email',
                'customers.*.address' => 'Địa chỉ',
                'customers.*.city' => 'Thành phố',
                'customers.*.state' => 'Bang',
                'customers.*.postal_code' => 'Mã bưu chính',
            ],
        ];
    }

    /**
     * Chuẩn bị dữ liệu trước khi validation.
     */
    protected function prepareForValidation(): void
    {
       // Nếu tên trường trong body là camelCase, bạn có thể chuyển đổi nó thành snake_case
    $customers = [];

    // Duyệt qua tất cả khách hàng từ request
    foreach ($this->input('customers', []) as $customer) {
        // In ra dữ liệu của customer để kiểm tra
        // dd($customer);

        // Chuyển camelCase thành snake_case cho các trường
        $customers[] = [
            'name' => $customer['name'],
            'type' => $customer['type'],
            'email' => $customer['email'],
            'address' => $customer['address'],
            'city' => $customer['city'],
            'state' => $customer['state'],
            'postal_code' => $customer['postalCode'],  // Chuyển từ camelCase sang snake_case
        ];
    }

    // Merge lại tất cả khách hàng vào request để tiếp tục validation
    $this->merge([
        'customers' => $customers,
    ]);

    }
}
