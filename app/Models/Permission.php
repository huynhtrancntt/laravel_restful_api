<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Mối quan hệ nhiều-nhiều với Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

}
