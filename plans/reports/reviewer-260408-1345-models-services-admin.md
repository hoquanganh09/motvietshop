# Code Review: Models / Services / Admin Layer
**Date:** 2026-04-08
**Scope:** app/Models/ (excl. User.php), app/Services/, app/Actions/Admin/, app/Http/Controllers/Admin/

---

## CRITICAL

### 1. PayOS — No Webhook Endpoint / Return-URL Signature Verification
**File:** `app/Services/PayOS.php:49`, `app/Http/Controllers/Client/ClientController.php:186-200`

`orderSuccess()` calls `getPaymentStatus($order->id)` and trusts the PayOS API response to mark `is_paid = true`. There is no server-side webhook endpoint that receives PayOS callbacks with HMAC verification. A user who guesses an `orderCode` (which is `order->id`, sequential integers) can call the return URL and the page tries to mark it paid — but relies solely on PayOS responding correctly. More critically, there is **no inbound webhook handler with checksum validation**, meaning payment status can only be confirmed by polling, and any network failure between PayOS and the server leaves orders permanently unpaid.

Fix: implement a dedicated POST webhook route (excluded from CSRF), verify `x-payos-signature` header against the payload using `checksum_key`, then update `is_paid`.

---

### 2. Coupon Race Condition — Amount Can Go Negative
**File:** `app/Http/Controllers/Client/CouponController.php:34`, `app/Services/OrderService.php:48`

The amount check (`amount <= 0`) happens at apply-time in the session. The decrement happens at order placement. Two concurrent users can both pass the check with `amount = 1`, both place orders, both decrement to -1. No `lockForUpdate()` or DB-level constraint prevents negative amounts.

Fix: inside the transaction, use `Coupon::lockForUpdate()->find($discount['id'])` and re-validate `amount > 0` before decrementing.

---

### 3. Stock Never Restored on Order Cancellation or Admin Deletion
**File:** `app/Http/Controllers/Client/OrderController.php:73`, `app/Actions/Admin/Order/DeleteOrderAction.php`

When a client cancels an order (`cancel()`) or admin deletes one (`DeleteOrderAction`), `Product::stock` is never incremented back. Stock is only decremented at placement (OrderService:54). This causes inventory undercount over time — cancelled/deleted items permanently reduce available stock.

Fix: wrap stock restoration inside both cancel and delete flows; load `orderDetails` and `increment('stock', $quantity)` per item inside the transaction.

---

### 4. `DeleteProductAction` — `$product->delete()` Outside Transaction
**File:** `app/Actions/Admin/Product/DeleteProductAction.php:37`

```php
DB::commit();          // line 35 — transaction ends
return $product->delete();  // line 37 — outside transaction
```

If `$product->delete()` fails after images/sizes/colors are already deleted and committed, the product row remains while all its associations are gone. The operation is non-atomic.

Fix: move `$product->delete()` inside the try block before `DB::commit()`.

---

### 5. `Order::shippingAddress()` — Broken Relationship Using `Builder::raw`
**File:** `app/Models/Order.php:134-136`

```php
->where('phone_number', \Illuminate\Database\Eloquent\Builder::raw('orders.phone_number'));
```

`Builder::raw()` does not exist (it's `DB::raw()`). This will throw a `BadMethodCallException` whenever `shippingAddress` is accessed. Even with `DB::raw`, the value would be treated as a literal string, not a column reference — the correct approach is `whereColumn()`.

Fix: use `->whereColumn('shipping_addresses.phone_number', 'orders.phone_number')` or remove the constraint if unused.

---

## IMPORTANT

### 6. Admin Order Status Update — No Input Validation
**File:** `app/Http/Controllers/Admin/OrderController.php:69-73`

`$request->input('status')` is passed directly to `UpdateOrderStatusAction` with no validation. An admin can set any arbitrary integer as `status`, bypassing the state machine entirely (e.g., jumping from PENDING directly to SHIPPED, or setting an invalid value).

Fix: add `$request->validate(['status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))]]);`

---

### 7. `UpdateOrderStatusAction` — Email Trigger Logic Is Confusing / Fragile
**File:** `app/Actions/Admin/Order/UpdateOrderStatusAction.php:21-28`

After `$order->status = $status`, `canShipping()` checks `$order->status == PROCESSING` and `canShipped()` checks `$order->status == SHIPPING`. The method names imply "CAN transition TO" but here they read the already-mutated status to decide "DID WE JUST ARRIVE AT". This works today but is semantically wrong — `canShipping()` should check the pre-transition state. If the guard methods are ever used elsewhere for their intended purpose, the email will fire incorrectly.

Fix: pass the previous status as context or use explicit equality checks on the new status value.

---

### 8. `DashboardService::getDataBetweenTime()` — Wrong Time Format (`H:m` → minutes parsed as month)
**File:** `app/Services/DashboardService.php:179`

```php
Carbon::parse($item->created_at->format('H:m'))
```

`%m` is months (01-12), not minutes. Should be `H:i`. For a timestamp of `06:48`, `H:m` outputs `06:04` (month=April). All hourly dashboard bucketing is silently wrong.

Fix: `$item->created_at->format('H:i')`

---

### 9. `getEarningCount` Excludes `COMPLETED` Orders
**File:** `app/Models/Order.php:160`

```php
->whereStatus(OrderStatus::SHIPPED->value)
```

Revenue only counts `SHIPPED` orders, not `COMPLETED`. The dashboard earnings figure is understated for any order that progresses past SHIPPED to COMPLETED.

Fix: `->whereIn('status', [OrderStatus::SHIPPED->value, OrderStatus::COMPLETED->value])`

---

### 10. `UserController::updateActive` — Unvalidated `status` Input
**File:** `app/Http/Controllers/Admin/UserController.php:120-129`

`$request->status` is written directly to `is_active` with no validation. Any integer value can be stored. Should validate `boolean` or `in:0,1`.

---

### 11. Admin `StoreUserRequest` — `is_admin` is Mass-Assignable and in Fillable
**File:** `app/Models/User.php:34`, `app/Http/Requests/Admin/User/StoreUserRequest.php`

`is_admin` is in `$fillable`. `StoreUserRequest` validates `role` as `nullable|numeric` with no range check — an admin could create a user with `role=1` (ROOT) or `is_admin=1` if those fields leak through. While `is_admin` isn't in the request rules, it's in `$fillable`, so if the controller ever calls `User::create($request->all())` it would be exploitable. Currently `User::create($request->validated())` is used — safe now, but `is_admin` should not be in `$fillable` at all.

---

### 12. `CreateProductAction` — Typo: `$imagse` Instead of `$images`
**File:** `app/Actions/Admin/Product/CreateProductAction.php:53`

```php
$imagse[] = $this->uploadProductImage(...);  // typo
```

The variable `$imagse` is never read; `$images` stays empty. On exception, image files uploaded during the loop are never cleaned up (orphaned files on disk). The error handler at line 90 iterates `$images` (always `[]`).

---

### 13. `Order::canReview()` — N+1 on `$this->reviews`
**File:** `app/Models/Order.php:118`

```php
$this->reviews->count() == 0
```

If `reviews` is not eager-loaded, each call triggers a query. This is used in `orderHistory()` view loops without `with('reviews')`.

Fix: eager-load `reviews` in `orderHistory()` query, or use `->withCount('reviews')` + `reviews_count == 0`.

---

### 14. `PayOS::createOrder` — `orderCode` Collides on High Load
**File:** `app/Services/PayOS.php:24`

```php
$orderCode = $order->id + time();
```

Two orders placed within the same second get different `orderCode` only if `id` differs. But `time()` is the same for all requests in one second — for orders placed simultaneously, the uniqueness relies entirely on auto-increment ID, which is fine but the addition is misleading and adds no entropy. The bigger issue: `orderCode` is not stored on the `Order` model, so after redirect back from PayOS there is no clean way to retrieve which order corresponds to which PayOS transaction (the `orderSuccess` route uses `orderCode` as if it's `order->id`, which it isn't).

---

## MINOR

### 15. `Coupon` Model — No Unique Index on `code`
**File:** `database/migrations/2024_08_27_173120_create_coupons_table.php`

No `->unique()` on `code` column at DB level. Duplicate codes can be inserted if two admins create simultaneously. The `CreateCouponAction` has no duplicate check.

---

### 16. `DashboardService` — `mapTypeToChartX` `THREE_MONTHS` Labels Are Fixed Quarters
**File:** `app/Services/DashboardService.php:94-99`

Labels are always "Quý 1, 2, 3, 4" regardless of current quarter. The actual data filters by `getDateByThreeMonth($data, $threeMonth)` which uses calendar-year quarters. A user selecting "Theo quý" in Q2 gets data labeled "Quý 1-4" but sees only current quarter's data split by quarter — confusing.

---

### 17. `DeleteOrderAction` — Doesn't Handle Coupon Amount Restoration
**File:** `app/Actions/Admin/Order/DeleteOrderAction.php`

When an order with a discount is deleted, `Coupon::amount` is not incremented back. Coupon uses are permanently consumed even if the order is removed.

---

### 18. `Role::users()` Relationship Uses Non-Standard FK Name
**File:** `app/Models/Role.php:18`

```php
return $this->hasMany(User::class, 'role');
```

Using the column `role` (an integer status field) as FK is confusing and non-standard. `getRole()` on User does the same in reverse. Naming a relationship `getRole` instead of `role` means `with('getRole')` works but is confusing and would break `$user->role` accessor semantics if Laravel tries to resolve it.

---

### 19. `Product::getThumbnail()` — Queries `$this->images` Without Eager Load Guard
**File:** `app/Models/Product.php:33`

Called in loops (e.g., dashboard best sellers) without checking if images were eager-loaded; causes silent N+1 if the eager-load chain is missing `images`.

---

### 20. `OrderDetail` — No Soft Deletes, Inconsistent with `Order`/`Product`
**File:** `app/Models/OrderDetail.php`

`Order` and `Product` use `SoftDeletes`, but `OrderDetail` doesn't. `DeleteOrderAction` hard-deletes order details. If order soft-delete is used for audit trails, detail rows disappear permanently.

---

## Summary

| Severity | Count |
|----------|-------|
| Critical | 5 |
| Important | 10 |
| Minor | 5 |

**Highest-risk items to fix immediately:** #1 (PayOS no webhook), #2 (coupon race), #3 (stock not restored), #4 (delete outside transaction), #5 (broken relationship method crash).

---

## Unresolved Questions

- Is there a webhook endpoint registered elsewhere not in scope? (searched `routes/web.php`, not found)
- Is `COMPLETED` status intentionally excluded from earnings, or is it a dead/unused status?
- Is `is_admin` field a legacy field being phased out, or is it actively used alongside `role`? The dual-check in `isRoot()` (`role == ROOT || is_admin == 1`) suggests possible inconsistency.
- Is `Order::shippingAddress()` relationship actually used anywhere? If not, remove it.
