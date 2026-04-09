# Code Review: Data Integrity & Business Logic Re-check
**Date:** 2026-04-08 | **Branch:** feature/ui-ux-enhancements

## Scope
14 files, ~500 LOC. Focus: data integrity, race conditions, security, business logic.

---

## Verification Results

| # | Item | Status | Notes |
|---|------|--------|-------|
| 1 | OrderService: `lockForUpdate()` on Product + stock check | CORRECT | L60–64: locks row, checks `stock < qty`, decrements inside transaction |
| 2 | OrderService: Coupon `lockForUpdate()` + re-validate `amount > 0` | CORRECT | L44–46: locks coupon, checks `amount <= 0`, throws if invalid |
| 3 | CartController: `quantity` validated `integer|min:1|max:1000` | CORRECT | L82 exact rule applied |
| 4 | OrderController::cancel(): stock restored in DB transaction | CORRECT | L78–85: `DB::transaction`, increments per detail |
| 5 | DeleteOrderAction: stock + coupon amount restored on delete | CORRECT | L19–27: stock incremented, coupon incremented by code |
| 6 | DeleteProductAction: `$product->delete()` inside transaction | CORRECT | L34: inside `DB::beginTransaction()` block |
| 7 | Order::shippingAddress(): uses `whereColumn()` | CORRECT | L136: `whereColumn('shipping_addresses.phone_number', 'orders.phone_number')` |
| 8 | PayOS: `payos_order_code` stored on order before API call | CORRECT | L43–44: assigned and saved before POST |
| 9 | PayOSWebhookController: HMAC-SHA256 + lookup by `payos_order_code` | PARTIAL — see Issue A |
| 10 | Job handlers: null guard if user deleted | CORRECT | All three order jobs: `if (!$user) return;` |
| 11 | SendMailForgotPasswordJob: uses `Password::broker()->sendResetLink()` | CORRECT | L36: correct broker call, guards unverified users |
| 12 | WishlistController: route model binding `Product $product` | CORRECT | L17: `store(Product $product)` |

---

## Issues Found

### A. HIGH — Webhook HMAC signs raw request body, not canonical PayOS fields
**File:** `PayOSWebhookController.php` L18–22
**Problem:** Signs `$request->getContent()` (raw JSON body). PayOS webhook spec requires HMAC over a sorted key=value query string of specific fields, the same format used in `PayOS::createOrder()` (`amount=...&cancelUrl=...`). Signing the full raw body means the check will always fail in production, silently falling through if PayOS ever sends the signature over a different canonical form — or it may produce timing-safe false negatives.
**Impact:** Payment status updates will be rejected (orders stuck unpaid) or, if the check were somehow bypassed, forged webhooks could mark orders as paid.
**Fix:** Extract and sort the canonical fields from `$payload`, build the same `key=value&...` string, then compare. Match exactly what `createOrder()` signs.

### B. LOW — `canReview()` signature mismatch (regression risk)
**File:** `Order.php` L117 vs `OrderController.php` L101
**Problem:** `Order::canReview()` takes no parameters, but `OrderController::shipped()` calls `$order->canReview('web')`. PHP silently ignores extra args, so it won't crash — but the string argument is meaningless and signals the caller expects branch logic that doesn't exist.
**Fix:** Either add a `$context = null` param and handle it, or remove the argument at the call site.

### C. LOW — DeleteOrderAction restores stock unconditionally for all statuses
**File:** `DeleteOrderAction.php` L19–21
**Problem:** Stock is incremented regardless of order status. If an admin deletes a `CANCEL`-ed order (whose stock was already restored on cancel), stock is double-incremented.
**Fix:** Guard with `if (!$order->isCancel())` before restoring stock.

### D. LOW — `SendMailForgotPasswordJon.php` filename typo (non-blocking)
**File:** filename `SendMailForgotPasswordJon.php` (missing 'b').
**Problem:** Does not affect functionality since the class name inside is correct (`SendMailForgotPasswordJob`) and callers import by class name. But the filename is misleading and violates kebab/PascalCase consistency.
**Fix:** Rename file to `SendMailForgotPasswordJob.php`.

### E. INFO — PayOS `orderCode` collision risk
**File:** `PayOS.php` L24
`$orderCode = $order->id + time()` — two near-simultaneous orders with IDs differing by the time delta could collide. Migration already adds a `unique` constraint so it will fail at DB level rather than silently. Low probability but worth noting.

---

## Positive Observations
- Transaction discipline is consistent across all write paths.
- `hash_equals()` used correctly in webhook (timing-safe comparison) — once the canonical string issue is fixed, the structure is sound.
- Null-guard pattern in all mail jobs is clean and uniform.
- `whereColumn()` usage in `shippingAddress()` is correct and avoids raw SQL injection.
- Coupon and stock restoration on both cancel and delete covers the main double-spend vectors.

---

## Recommended Actions
1. **[HIGH]** Fix webhook HMAC to sign canonical field string, not raw body.
2. **[LOW]** Guard stock restore in `DeleteOrderAction` against already-cancelled orders.
3. **[LOW]** Fix `canReview()` signature mismatch.
4. **[LOW]** Rename `SendMailForgotPasswordJon.php` → `SendMailForgotPasswordJob.php`.

---

## Unresolved Questions
- Does PayOS's actual webhook spec sign raw body or canonical fields? Confirm against PayOS docs before applying fix A — current implementation may be intentional if their spec changed.
- Is `canReview('web')` intended to support a future mobile vs web context split? If so, add the parameter to the model method.
