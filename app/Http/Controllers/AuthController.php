<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if (!$email || !$password) {
            return response()->json([
                'message' => 'Please provide both email and password'
            ], 400);
        }

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            // create a token for the user
            $token = auth()->user()->createToken('auth');

            $response = config('api_response.success_response');
            $response['data'] = [
                'user' => auth()->user(),
                'token' => $token->plainTextToken
            ];
            $response['message'] = 'Login successful';

            return response()->json($response, 200);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $response = config('api_response.success_response');
        $response['message'] = 'Logout successful';

        return response()->json($response, 200);
    }

    public function profile(Request $request)
    {
        $response = config('api_response.success_response');
        $response['data'] = $request->user();
        $response['message'] = 'User details.';

        return response()->json($response);
    }



    public function login_jwt(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth("api")->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout_jwt()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL() * 60 // thời gian hết hạn token (mặc định 60 phút)
        ]);
    }
    public function profile_jwt()
    {
        return response()->json(auth()->user());
    }

}
