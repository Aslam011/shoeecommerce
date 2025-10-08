<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'address_type',
        'payment_method',
        'payment_session_id',
        'payment_transaction_id',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'total_amount',
        'status',
        'tracking_number',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}
