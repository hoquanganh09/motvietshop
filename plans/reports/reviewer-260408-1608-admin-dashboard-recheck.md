# Code Review: Admin/Dashboard/Model/Config Fix Pass
**Date:** 2026-04-08 | **Branch:** feature/ui-ux-enhancements

---

## Verification Results

### 1. AdminOrderController — `Rule::in(OrderStatus::cases())` validation
**CORRECT.**
Line 72: `Rule::in(array_column(\App\Enums\OrderStatus::cases(), 'value'))` — correctly extracts int values from backed enum before passing to `Rule::in`. Handles all 6 statuses (CANCEL=1 through COMPLETED=6).

### 2. UserController::changeNoti() — boolean validation
**CORRECT.**
Lines 51-53: Both `has_send_email_order` and `has_send_email_shipping` use `'sometimes|boolean'`. `sometimes` means the rule only fires if the field is present, which is correct for a toggle endpoint. No regression.

### 3. CreateProductAction — `$imagse` typo
**CORRECT.**
Variable is `$images` throughout (lines 30, 52, 53, 91). Typo is gone. Rollback logic on lines 90-92 is also correct.

### 4. DashboardService — `H:m` → `H:i` + `getEarningCount` includes COMPLETED
**H:i fix: CORRECT.** Line 178: `$item->created_at->format('H:i')` — correct minute format specifier.
**COMPLETED fix: CORRECT.** `Order::getEarningCount()` at `Order.php:161` uses `whereIn('status', [OrderStatus::SHIPPED->value, OrderStatus::COMPLETED->value])`.

### 5. DashboardService quarterly labels — dynamic current quarter
**CORRECT.**
Lines 95-99: `$currentQuarter = (int) ceil(now()->month / 3)` then appends `' (hiện tại)'` to the matching quarter. Dynamic, no hardcoded quarter number.

### 6. Product::getThumbnail() — guard against N+1
**CORRECT with a minor caveat.**
Lines 33-35: `if (!$this->relationLoaded('images'))` returns default/null without triggering a query. Guards N+1 as intended.
**Caveat (low):** When `$withDefault = false` and relation is loaded but `is_on_top` is false on the first image, it returns `null` silently. This is existing behavior, not a regression from the fix.

### 7. ChangePassword — `current_password` required when user has password
**CORRECT.**
Line 28: `Rule::requiredIf(fn() => auth()->user()?->password !== null)` — conditional requirement. `'nullable'` after it is redundant when `requiredIf` resolves to true (Laravel ignores it), but it correctly allows omission for OAuth/passwordless accounts. No functional issue.

### 8. StoreReviewRequest — `arr.*.note` max:2000
**CORRECT.**
Line 28: `'arr.*.note' => 'nullable|string|max:2000'`. Constraint is present.

### 9. session.php — `SESSION_SECURE_COOKIE` explicit false default
**CORRECT.**
Line 172: `'secure' => env('SESSION_SECURE_COOKIE', false)`. Explicit `false` default prevents PHP `null` being cast to a truthy value in some driver paths. Fix is sound.

### 10. Migrations

| Migration | Verdict |
|---|---|
| `2026_04_08_154400` — `payos_order_code` to `orders` | **CORRECT.** `bigInteger`, nullable, unique, positioned after `id`. `down()` drops column cleanly. |
| `2026_04_08_154401` — unique index on `coupons.code` | **CORRECT.** `up()` adds unique, `down()` drops via `dropUnique(['code'])`. No data-loss risk since this is an index-only migration. |
| `2026_04_08_154402` — soft deletes on `order_details` | **CORRECT.** `softDeletes()` / `dropSoftDeletes()` are symmetrical. Ensure `OrderDetail` model uses `SoftDeletes` trait if not already. |

---

## Summary

All 10 targeted fixes verified as **CORRECT**. No regressions detected.

**One follow-up item:**
- Migration `154402` adds `deleted_at` to `order_details` — confirm `OrderDetail` model has `use SoftDeletes` trait, otherwise soft-delete calls will hard-delete silently.

---

## Unresolved Questions
- Is `OrderDetail` model updated to use `SoftDeletes` trait after migration `154402`?
