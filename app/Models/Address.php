<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'full_name',
        'mobile_number',
        'email',
        'phone',
        'address',
        'flat_house_no',
        'area_street',
        'landmark',
        'town_city',
        'city',
        'state',
        'postal_code',
        'pincode',
        'country',
        'type',
        'is_default',
        'default_address',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
