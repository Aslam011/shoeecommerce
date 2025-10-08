<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'is_active',
        'api_key',
        'api_secret',
        'merchant_id',
        'salt_key',
        'salt_index',
        'environment',
        'webhook_secret',
        'additional_config',
        'sort_order',
        'supports_upi',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'supports_upi' => 'boolean',
        'additional_config' => 'array',
    ];

    /**
     * Get active payment gateways
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Check if gateway is configured
     */
    public function isConfigured(): bool
    {
        switch ($this->name) {
            case 'razorpay':
                return !empty($this->api_key) && !empty($this->api_secret);
            
            case 'phonepe':
                return !empty($this->merchant_id) && !empty($this->salt_key) && !empty($this->salt_index);
            
            case 'paytm':
                return !empty($this->merchant_id) && !empty($this->merchant_key);
            
            case 'cashfree':
                return !empty($this->api_key) && !empty($this->api_secret);
            
            default:
                return false;
        }
    }

    /**
     * Get configuration for payment gateway
     */
    public function getConfig(): array
    {
        return [
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
            'merchant_id' => $this->merchant_id,
            'salt_key' => $this->salt_key,
            'salt_index' => $this->salt_index,
            'environment' => $this->environment,
            'webhook_secret' => $this->webhook_secret,
            'additional_config' => $this->additional_config ?? [],
        ];
    }
}
