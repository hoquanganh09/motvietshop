# Code Review: Client Routes, Controllers, Actions, Config

**Date:** 2026-04-08
**Branch:** feature/ui-ux-enhancements
**Reviewer:** code-reviewer agent

---

## Scope

- `app/Http/Controllers/Client/` (7 controllers, non-auth)
- `app/Actions/Client/` (7 actions)
- `app/Services/OrderService.php`, `PayOS.php`
- `routes/web.php`, `routes/admin.php`
- `config/app.php`, `database.php`, `session.php`, `filesystems.php`
- `app/Jobs/` (5 jobs), `app/Mail/` (5 mails), `app/Helpers/Helper.php`

---

## Critical Issues

### C1 — IDOR on `orderSuccess` (no ownership check)
**File:** `ClientController.php:188`

```php
$order = Order::query()->find(request()->input('orderCode'));
```

Any authenticated user can pass `?orderCode=<any_id>` and view/confirm payment for another user's order. The `orderCode` is the internal DB `id`. Unlike `OrderController::show()` which checks `user_id`, `orderSuccess()` has no such guard. This also calls `$order->is_paid = true; $order->save()` on an arbitrary order.

**Fix:** Add `->where('user_id', Auth::id())` or abort 403.

---

### C2 — Race condition on stock decrement
**File:** `OrderService.php:54`

```php
Product::query()->where('id', $item['id'])->decrement('stock', $item['quantity']);
```

No `lockForUpdate()` before checking stock vs. decrement. Concurrent orders can oversell. The stock check in `CalculateCartQuantityAction` happens at checkout page load, not atomically at order placement.

**Fix:** Use `lockForUpdate()` inside the transaction when fetching product stock before decrement, or add a DB constraint (`stock >= 0`).

---

### C3 — Shipping address IDOR on update and destroy
**Files:** `ShippingAddressController.php:24,31`

Neither `update()` nor `destroy()` verifies that the `ShippingAddress` belongs to the authenticated user. Route model binding resolves any ID. An attacker can delete or overwrite any user's shipping address.

**Fix:** Add authorization check:
```php
if ($shippingAddress->user_id !== Auth::id()) abort(403);
```
Or use a Policy.

---

### C4 — Cart `updateQuantity` accepts arbitrary quantity (no validation)
**File:** `CartController.php:83`

```php
$carts[$key]['quantity'] = $request->input('quantity');
```

No type check, no min/max bounds. An attacker can set `quantity = 0`, `-1`, `999999`, or non-integer. This bypasses the stock check done at checkout load, and the `OrderService` uses `final_cart` from session — which was correctly validated at page load but `updateQuantity` can mutate `cart` after that point.

**Fix:** Validate `quantity` as `integer|min:1|max:$product->stock`.

---

## Important Issues

### I1 — Password reset sends plaintext password by email
**Files:** `SendMailForgotPasswordJon.php:34-39`, `ForgotPassword.php:19`

Password hashing was fixed (storing `Hash::make()`), but the **plaintext** new password is still passed to the `ForgotPassword` mailable and emailed to the user. This is not cryptographically recoverable, but it means a plaintext credential travels through mail servers and is visible to email providers.

Industry standard: send a time-limited reset token/link, not a new plaintext password. The current approach also cannot be invalidated after use.

---

### I2 — Null pointer dereference in 3 job handlers
**Files:** `SendMailOrderCreated.php:34`, `SendMailOrderShippingJob.php:31`, `SendMailOrderConfirmedJob.php:31`

```php
$user = User::find($this->userId);
if ($user->has_send_email_order ...) // Fatal if $user is null
```

If a user is deleted after the job is dispatched, `$user` is `null` and the job crashes with a fatal error, exhausting retries and filling the failed jobs table.

**Fix:** Add `if (!$user) return;` guard.

---

### I3 — Wishlist `store()` skips product existence check
**File:** `WishlistController.php:22-27`

`store(string|int $product)` receives the product ID from the route but never validates it exists (no `findOrFail`, no route model binding typed as `Product`). Arbitrary integer IDs can be inserted into wishlists, causing orphaned rows and potential FK violations if the DB doesn't enforce it.

**Fix:** Change signature to `store(Product $product)` to use route model binding.

---

### I4 — Coupon discount applied on session, not re-validated at order time
**File:** `OrderService.php:36,48`

`total` and `discount` are calculated from `getCartDiscountTotal()` / `getCartDiscount()`, which read the `discount` session key set by `CouponController`. There is no re-validation that:
- The coupon is still active
- The coupon still has `amount > 0`
- The coupon hasn't expired

A user could apply a valid coupon, wait for it to expire/deplete, then complete the order still getting the discount.

**Fix:** Re-fetch and re-validate the coupon in `OrderService::placeOrder()` before applying it.

---

### I5 — PayOS `orderCode` is predictable and leaks internal order IDs
**File:** `PayOS.php:24`

```php
$orderCode = $order->id + time();
```

The PayOS order code is computed as `order.id + unix_timestamp`. This leaks the internal sequential order ID and `time()` is deterministic enough to be guessable. PayOS uses `orderCode` to match webhooks/callbacks.

**Fix:** Use `Order::generateCode()` or a UUID-based approach rather than `id + time()`.

---

### I6 — `orderSuccess` marks `is_paid = true` without verifying order belongs to current user (relates to C1)
**File:** `ClientController.php:197-200`

Follows from C1 — this additionally writes to DB (`$order->is_paid = true; $order->save()`), not just reads. Any user can mark any online payment order as paid by supplying the right `orderCode`.

---

### I7 — `changeNoti` accepts unbounded truthy values
**File:** `UserController.php:56-65`

`$request->input('has_send_email_order')` is assigned directly to the user model attribute without validation. Any value is accepted (including strings, arrays). Should be validated as `boolean`.

---

## Minor Issues

### M1 — `productViewed` session poisoning via large arrays
**File:** `ClientController.php:88-92`

The `productViewed` session array grows unbounded. No max size limit. A user visiting many products bloats the session row and could degrade performance on a DB-backed session driver.

**Fix:** Cap array at ~20 entries with `array_slice`.

---

### M2 — `wishlist()` missing `user_id` filter
**File:** `ClientController.php:121-125`

```php
$wishlists = Wishlist::query()->with([...])->paginate();
```

No `where('user_id', Auth::id())`. Returns wishlists for ALL users. Although the route is behind `customAuth`, this leaks every user's wishlist data to any authenticated user.

---

### M3 — `session.secure` not explicitly set to `true`
**File:** `config/session.php:172`

```php
'secure' => env('SESSION_SECURE_COOKIE'),
```

Defaults to `null` (falsy). If `SESSION_SECURE_COOKIE` is not set in `.env`, session cookies are transmitted over HTTP. Should default to `true` in production or be explicitly checked.

---

### M4 — `session.encrypt` defaults to false
**File:** `config/session.php:50`

Cart data (including prices and discount state) is stored in plain sessions. Session data is not encrypted at rest. Given `SESSION_DRIVER=database`, any DB-level access exposes cart/coupon state.

---

### M5 — Typo in job class name
**File:** `app/Jobs/SendMailForgotPasswordJon.php`

Class name `SendMailForgotPasswordJon` — `Jon` should be `Job`. Low impact but misleading.

---

### M6 — Admin `profile/{user}` route has no ownership/permission check visible in routes
**File:** `routes/admin.php:26`

`Route::get('/profile/{user}', 'profile')` — any admin can view any user's profile by ID. Depends on whether `HomeController::profile()` enforces role permissions — could not be verified without reading that controller, but worth auditing.

---

## Positive Observations

- IDOR fixes applied correctly in `OrderController` (show, cancel, shipped, showNeedReviews) — all check `user_id === Auth::id()`.
- Wishlist `destroy()` correctly scopes to `auth()->id()`.
- `ReviewController` validates purchase ownership before creating review — solid logic.
- `StoreShippingAddressAction` correctly injects `Auth::id()` server-side, not trusting client input.
- Throttling applied to sensitive endpoints (login, register, forgot password, coupon apply).
- `APP_DEBUG` defaults to `false` in production (`config/app.php:42`).
- Coupon `amount <= 0` and expiry checks present in `CouponController`.
- DB transaction with rollback in both `OrderService` and `ReviewController`.

---

## Recommended Actions (Priority Order)

1. **[C1/I6]** Add `where('user_id', Auth::id())` in `ClientController::orderSuccess()`.
2. **[C3]** Add ownership guard in `ShippingAddressController::update()` and `destroy()`.
3. **[C2]** Add `lockForUpdate()` + stock re-check inside the DB transaction in `OrderService`.
4. **[C4]** Validate `quantity` as `integer|min:1` in `CartController::updateQuantity()`.
5. **[I4]** Re-validate coupon in `OrderService::placeOrder()` before applying discount.
6. **[I2]** Add null guard `if (!$user) return;` in all 3 job handlers.
7. **[M2]** Add `->where('user_id', Auth::id())` in `ClientController::wishlist()`.
8. **[I3]** Change `WishlistController::store()` to typed route model binding `Product $product`.
9. **[I1]** Replace plaintext-password email with token-based reset link.
10. **[M3]** Set `SESSION_SECURE_COOKIE=true` in production `.env`.

---

## Unresolved Questions

- Does `AdminHomeController::profile()` enforce role/permission checks for `admin/profile/{user}`?
- Is there a PayOS webhook handler that verifies the HMAC signature on incoming callbacks? Not found in scope.
- Is there a queue worker retry policy configured? If jobs fail (e.g., null user — I2), unlimited retries will fill `failed_jobs`.
