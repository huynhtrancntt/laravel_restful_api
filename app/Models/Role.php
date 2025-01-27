<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Mối quan hệ nhiều-nhiều với Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    // Mối quan hệ nhiều-nhiều với User
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
