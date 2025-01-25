<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'email',
        'address',
        'city',
        'state',
        'postalCode',
    ];
    // Mutator: Chuyển `postalCode` thành `postal_code` khi lưu vào DB
    public function setPostalCodeAttribute($value)
    {
        $this->attributes['postal_code'] = $value; // Lưu thành snake_case
    }

    // Accessor: Trả về `postalCode` khi truy cập
    public function getPostalCodeAttribute()
    {
        return $this->attributes['postal_code'];
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
