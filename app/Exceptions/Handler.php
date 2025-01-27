<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\ExpiredException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * Tùy chỉnh cách xử lý lỗi ValidationException.
     */
    public function render($request, Throwable $exception)
    {
        // Nếu là lỗi ValidationException (lỗi dữ liệu không hợp lệ)
        if ($exception instanceof ValidationException) {
            $errors = $exception->errors();

            // Trả về response JSON với lỗi tùy chỉnh
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $errors
            ], 422);

        }

        if ($exception instanceof JWTException) {
            return response()->json([
                'error' => 'Token is invalid.',
            ], 401);
        }

        if ($exception instanceof ExpiredException) {
            return response()->json([
                'error' => 'Token has expired.',
            ], 401);
        }

        // Xử lý lỗi "Could not decode token: Error while decoding from JSON"
        if ($exception instanceof UnexpectedValueException) {
            return response()->json([
                'error' => 'Could not decode token: Error while decoding from JSON.',
            ], 400);
        }
        // if($exception instanceof UnauthorizedHttpException){
        //     return response()->json([
        //         'error' => 'Could not decode token: Error while decoding from JSON..',
        //     ], 401);
        // }

        // Nếu không phải lỗi validation, sử dụng mặc định
        return parent::render($request, $exception);
    }

}
