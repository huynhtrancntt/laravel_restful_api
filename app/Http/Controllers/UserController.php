<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request()->query('limit', 10);
        $users = User::latest();
        if(request()->query('name')) {
            $users = $users->where('name', 'like', '%'.request()->query('name').'%');
        }
        $users = $users->paginate($limit);

        $response = config('api_response.pagination_response');
        $response['data'] = $users->items();
        $response['pagination'] = [
            'total' => $users->total(),
            'per_page' => $users->perPage(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
        ];
        $response['message'] = 'List of paginated users.';

        return response()->json($response);
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
    public function store(UserRequest $request)
    {
        // Dữ liệu đã được xác thực
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $response = config('api_response.success_response');
        $response['data'] = $user;
        $response['message'] = 'User created successfully.';

        return response()->json($response,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user) {
            $response = config('api_response.error_response');
            $response['message'] = 'User not found.';

            return response()->json($response);
        }
        $response = config('api_response.success_response');
        $response['data'] = $user;
        $response['message'] = 'User details.';

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
         $user = User::find($id);
        if(!$user) {
            $response = config('api_response.error_response');
            $response['message'] = 'User not found.';

            return response()->json($response);
        }
        if($request->has('name')) {
            $user->name = $request->name;
        }
        if($request->has('email')) {
            $user->email = $request->email;
        }
        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $response = config('api_response.success_response');
        $response['data'] = $user;
        $response['message'] = 'User updated successfully.';

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
