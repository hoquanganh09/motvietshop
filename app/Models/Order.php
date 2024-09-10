<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id',
        'fullname',
        'address',
        'phone_number',
        'payment_method',
        'note',
        'is_paid',
        'status',
        'total',
        'code',
        'discount',
        'discount_code',
    ];

    public function getStatusLabel()
    {
        switch ($this->status) {
            case OrderStatus::CANCEL->value:
                return 'Đã hủy';
            case OrderStatus::PENDING->value:
                return 'Chờ xác nhận';
            case OrderStatus::SHIPPING->value:
                return 'Đang giao hàng';
            case OrderStatus::SHIPPED->value:
                return 'Đã giao';
            case OrderStatus::COMPLETED->value:
                return 'Đã hoàn thành';
            case OrderStatus::PROCESSING->value:
                return 'Đang xử lý';
        }
    }

    public function getStatusColor()
    {
        switch ($this->status) {
            case OrderStatus::CANCEL->value:
                return '#f03d3d';
            case OrderStatus::PENDING->value:
                return '#fc9231';
            case OrderStatus::SHIPPING->value:
                return '#2358ae';
            case OrderStatus::SHIPPED->value:
                return '#33b36b';
            case OrderStatus::COMPLETED->value:
                return '#33b36b';
            case OrderStatus::PROCESSING->value:
                return '#2f6ed5';
        }
    }

    public function getPaymentMethodLabel()
    {
        switch ($this->payment_method) {
            case PaymentMethod::Cod->value:
                return 'Thanh toán khi nhận hàng';
            case PaymentMethod::Online->value:
                return 'Thanh toán Online';
        }
    }

    public static function generateCode()
    {
        $code = \Illuminate\Support\Str::random(10);

        $codeExist = self::query()->where('code', $code)->first();

        while ($codeExist) {
            $code = \Illuminate\Support\Str::random(10);

            $codeExist = self::query()->where('code', $code)->first();
        }

        return strtoupper($code);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function isPaid()
    {
        return $this->is_paid ? true : false;
    }

    public function canCancel()
    {
        return $this->status == OrderStatus::PENDING->value && !$this->isPaid();
    }

    public function getPaidLabel()
    {
        return $this->isPaid() ? 'Đã thanh toán' : 'Chưa thanh toán';
    }
}
