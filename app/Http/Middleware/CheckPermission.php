<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        // $user = JWTAuth::user();
        // $permissions = $user->; // Lấy permissions từ user

        $user = auth()->user();

        // Lấy thông tin role và permissions của người dùng
        // $roles = $user->roles->pluck('name')->toArray();  // Lấy tên role
        $permissions = $user->roles->pluck('permissions')->flatten()->pluck('name')->toArray();  // Lấy tên permissions từ các role

        // Kiểm tra nếu permissions không phải là mảng hoặc trống
        if (is_array($permissions) && in_array($permission, $permissions)) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

}
