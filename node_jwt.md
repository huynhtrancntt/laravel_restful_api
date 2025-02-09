1. Cài đặt thư viện JWT

Trước tiên, cần cài đặt thư viện hỗ trợ JWT cho Laravel:

composer require tymon/jwt-auth
Tiếp theo, publish file cấu hình của JWT:

php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

File cấu hình JWT sẽ được lưu tại: config/jwt.php.

2. Tạo secret key
   JWT yêu cầu một secret key để mã hóa token. Bạn có thể tạo secret key bằng lệnh:

php artisan jwt:secret
Lệnh trên sẽ tạo một key và lưu vào file .env với tên:

JWT_SECRET=your_generated_secret

3. Thiết lập User Model
   Thêm interface JWTSubject vào model User để hỗ trợ JWT. Sửa file App\Models\User như sau:

<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    // Các thuộc tính mặc định của User...

    // Các phương thức của JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
