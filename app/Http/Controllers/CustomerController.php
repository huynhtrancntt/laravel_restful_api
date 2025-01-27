<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use Illuminate\Http\Request;
use App\Services\V1\CustomerFilter;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\BulkStoreCustomerRequest;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Sử dụng CustomerFilter
        $filter = new CustomerFilter();
        $queryItems = $filter->transform($request);

        $includeInvoices = $request->query('includeInvoices');

        // Xây dựng query
        $customersQuery = Customer::where($queryItems);
        if ($includeInvoices) {
            $customersQuery = $customersQuery->with('invoices');
        }

        // Paginate dữ liệu
        $customers = $customersQuery->paginate()->appends($request->query());

        // Trả về JSON với cấu trúc chuẩn sử dụng CustomerCollection
        return response()->json([
            'success' => true,
            'message' => 'Customer list retrieved successfully.',
            'data' => new CustomerCollection($customers), // Sử dụng CustomerCollection,
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    public function bulkStore(BulkStoreCustomerRequest $request)
    {
        // Lấy tất cả dữ liệu khách hàng từ request
        $customersData = $request->input('customers');

        // Duyệt qua mỗi khách hàng và tạo mới
        foreach ($customersData as $customerData) {
            // Tạo khách hàng mới mà không cần kiểm tra sự tồn tại
            $customer = Customer::insert($customerData);
        }

        // Trả về kết quả với CustomerResource::collection
        return response()->json([
            'success' => true,
            'message' => 'Customers created successfully.',
            'data' => '',
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Tìm customer hoặc trả về lỗi
            $customer = Customer::findOrFail($id);

            // Kiểm tra query parameter includeInvoices
            $includeInvoices = request()->query('includeInvoices');

            // Load invoices nếu includeInvoices được truyền
            if ($includeInvoices) {
                $customer->loadMissing('invoices');
            }

            // Trả về JSON với cấu trúc yêu cầu
            return response()->json([
                'success' => true,
                'message' => 'User details.',
                'data' => new CustomerResource($customer),
            ], 200);

        } catch (ModelNotFoundException $e) {

            // Xử lý khi không tìm thấy model
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully.',
            'data' => new CustomerResource($customer),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
