<?php

namespace App\Services;

use App\Enums\CartStatus;
use App\Enums\OrderStatus;
use App\Jobs\SendMailOrderCreated;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @throws \Exception
     */
    public function placeOrder(array $validatedData): Order
    {
        $cart = getCart(CartStatus::NotDisabled, 'final_cart');

        if (count($cart) == 0) {
            throw new \Exception('Không thể đặt hàng khi không có sản phẩm');
        }

        $discount = getDiscount();
        $data = [
            'user_id' => Auth::id(),
            'fullname' => $validatedData['fullname'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
            'payment_method' => $validatedData['payment_method'],
            'note' => $validatedData['note'] ?? null,
            'status' => OrderStatus::PENDING->value,
            'total' => getCartDiscountTotal(CartStatus::NotDisabled, 'final_cart'),
            'code' => Order::generateCode(),
        ];

        DB::beginTransaction();
        try {
            if ($discount) {
                // C10: Re-fetch coupon with lock to prevent race condition on amount
                $coupon = Coupon::lockForUpdate()->find($discount['id']);
                if (!$coupon || $coupon->amount <= 0) {
                    throw new \Exception('Mã giảm giá không còn hiệu lực');
                }
                $data = [
                    ...$data,
                    'discount' => getCartDiscount(CartStatus::NotDisabled, 'final_cart'),
                    'discount_code' => $discount['code'],
                ];
                $coupon->decrement('amount');
            }

            $order = Order::create($data);

            foreach ($cart as $item) {
                // C7: Lock product row and check stock before decrementing to prevent oversell
                $product = Product::lockForUpdate()->find($item['id']);
                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception('Sản phẩm "' . ($product->name ?? $item['id']) . '" không đủ số lượng trong kho');
                }
                $product->decrement('stock', $item['quantity']);
                $order->orderDetails()->create([
                    'product_id' => $item['id'],
                    'color_id' => $item['color'],
                    'size_id' => $item['size'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            SendMailOrderCreated::dispatch($order->user_id, $order);

            DB::commit();

            session()->put('cart', []);
            session()->put('final_cart', []);

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
