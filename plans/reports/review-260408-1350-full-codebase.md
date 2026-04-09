# Full Codebase Review — motvietshop
**Date:** 2026-04-08 | **Branch:** feature/ui-ux-enhancements
**Stack:** Laravel 11, PHP 8.2, MySQL

Sub-reports:
- `reviewer-260408-1345-security-auth.md`
- `reviewer-260408-1345-client-routes-config.md`
- `reviewer-260408-1345-models-services-admin.md`

---

## Totals (deduplicated)

| Severity | Count |
|----------|-------|
| Critical | 13 |
| Important | 16 |
| Minor | 14 |
| **Total** | **43** |

---

## CRITICAL (fix immediately)

### AUTH / SESSION
| # | File | Issue |
|---|------|-------|
| C1 | `Actions/Client/Auth/LoginAction.php:30`, `Actions/Admin/Auth/LoginAction.php:27` | **Session fixation** — no `session()->regenerate()` after successful login |
| C2 | `Controllers/Client/AuthController.php:71`, `Actions/Admin/Auth/LogoutAction.php` | **Logout doesn't invalidate session** — no `invalidate()` + `regenerateToken()` |
| C3 | `routes/admin.php` — `POST /admin/dang-nhap` | **Admin login brute-forceable** — zero rate limiting; client login has `throttle:10,1` |
| C4 | `Models/User.php:34,38` | **`is_admin`, `role`, `email_verified_at` mass-assignable** in `$fillable` |

### IDOR / AUTHORIZATION
| # | File | Issue |
|---|------|-------|
| C5 | `Controllers/Client/ClientController.php:188,197` | **IDOR on `orderSuccess`** — no `user_id` check; any user can view & mark any order as paid |
| C6 | `Controllers/Client/ShippingAddressController.php:24,31` | **ShippingAddress IDOR** — `update`/`destroy` never verify ownership |

### DATA INTEGRITY
| # | File | Issue |
|---|------|-------|
| C7 | `Services/OrderService.php:54` | **Stock race condition** — no `lockForUpdate()`, concurrent orders can oversell |
| C8 | `Controllers/Client/CartController.php:83` | **Cart `updateQuantity` — no validation**; accepts 0, negative, non-integer quantity |
| C9 | `Services/PayOS.php:49`, `ClientController.php:186` | **No PayOS webhook + HMAC verification** — payment status only confirmed by polling; network failure = permanently unpaid order |
| C10 | `Controllers/Client/CouponController.php:34`, `Services/OrderService.php:48` | **Coupon race condition** — `amount <= 0` check at apply-time, decrement at order-time, no lock; two users can both succeed with `amount=1` |
| C11 | `Controllers/Client/OrderController.php:73`, `Actions/Admin/Order/DeleteOrderAction.php` | **Stock never restored** on cancel or admin delete — inventory permanently understated |
| C12 | `Actions/Admin/Product/DeleteProductAction.php:37` | **`$product->delete()` outside DB transaction** — images/sizes deleted and committed, then product delete can fail, leaving orphaned data |
| C13 | `Models/Order.php:134` | **`Order::shippingAddress()` crashes** — uses `Builder::raw()` (non-existent); throws `BadMethodCallException` at runtime |

---

## IMPORTANT (fix before next release)

### Security
- **I1** `Actions/Admin/Auth/LogoutAction.php` — Any admin can trigger password reset for ROOT (`resetPassword` has no `FormRequest`, no role check)
- **I2** `Http/Middleware/CustomGuest.php:28-33` — Dead `to_route()` after `return`; browser users get raw JSON 401 instead of redirect
- **I3** `Requests/Client/Auth/ForgotPasswordRequest.php:25` — `exists:users,email` validation rule leaks account existence (returns 422 confirming email registered)
- **I4** `Actions/Client/Auth/LoginSocialAction.php:34` — Social login bypasses account ban; force-sets `is_active = 1`
- **I5** `Requests/Client/Auth/RegisterRequest.php:25` — No password `min:` rule; 1-char passwords accepted

### Business Logic
- **I6** `Jobs/SendMailForgotPasswordJon.php:34` — Password reset emails **plaintext password**; should be token-based reset link
- **I7** `Jobs/SendMailOrder*.php:31-34` — 3 job handlers fatal-crash if user deleted before job runs; no null guard
- **I8** `Controllers/Client/WishlistController.php:22` — `store()` never validates product ID exists; orphaned wishlist rows possible
- **I9** `Services/OrderService.php:36,48` — Coupon **not re-validated** at order placement; expired/depleted coupons still apply
- **I10** `Services/PayOS.php:24` — `orderCode = order->id + time()` not stored on order; return-URL lookup broken (`orderSuccess` treats `orderCode` as `order->id`)
- **I11** `Controllers/Client/UserController.php:56` — `changeNoti` writes unvalidated truthy value to boolean `is_active` fields
- **I12** `Controllers/Admin/OrderController.php:69` — Admin order status update accepts any integer; no `Rule::in(OrderStatus::cases())`
- **I13** `Actions/Admin/Product/CreateProductAction.php:53` — Typo `$imagse` — uploaded images silently orphaned; error handler iterates empty `$images`

### Dashboard / Data
- **I14** `Services/DashboardService.php:179` — **`H:m` instead of `H:i`** — hours/minutes bucketing silently wrong (`m` = month in PHP)
- **I15** `Models/Order.php:160` — `getEarningCount` excludes `COMPLETED` orders; revenue understated
- **I16** `Controllers/Client/ClientController.php:121` — `wishlist()` missing `->where('user_id', Auth::id())` — returns **all users' wishlists** to any authenticated user

---

## MINOR

| # | File | Issue |
|---|------|-------|
| M1 | `Requests/Client/User/ChangePassword.php:27` | `current_password` nullable — social bypass unclear, should be explicit |
| M2 | `Requests/Client/Review/StoreReviewRequest.php:28` | `arr.*.note` no `max` length — unbounded DB write |
| M3 | `Http/Middleware/Visitor.php:20` | `str_contains($url, 'admin')` — use `$request->is('admin/*')` |
| M4 | `Http/Middleware/CustomAuth.php:19` | No fallback for unknown guard string — throws undefined array key |
| M5 | `Jobs/SendMailForgotPasswordJon.php` | Class name typo: `Jon` should be `Job` |
| M6 | `Controllers/Client/ClientController.php:88` | `productViewed` session array grows unbounded — no max size cap |
| M7 | `config/session.php:172` | `SESSION_SECURE_COOKIE` defaults to `null` — cookies sent over HTTP if not set |
| M8 | `config/session.php:50` | `session.encrypt` = false — cart/coupon state unencrypted in DB session rows |
| M9 | `migrations/2024_08_27_173120_create_coupons_table.php` | No `->unique()` on `coupons.code` — duplicate coupon codes possible under concurrency |
| M10 | `Services/DashboardService.php:94` | Q1-Q4 labels hardcoded regardless of selected period |
| M11 | `Actions/Admin/Order/DeleteOrderAction.php` | Coupon `amount` not restored on order deletion |
| M12 | `Models/Role.php:18` | `Role::users()` uses `role` (status int) as FK — non-standard, confusing |
| M13 | `Models/Product.php:33` | `getThumbnail()` triggers N+1 if `images` not eager-loaded |
| M14 | `Models/OrderDetail.php` | No `SoftDeletes` — inconsistent with `Order`/`Product`; hard-delete breaks audit trail |

---

## Fix Priority Order

### Week 1 — Patch Now
1. **C1/C2** — Session regenerate on login + invalidate on logout (2 files, trivial)
2. **C3** — Add `throttle:5,1` to admin login route
3. **C5** — Add `->where('user_id', Auth::id())` in `orderSuccess()`
4. **C6** — Add `abort_if($address->user_id !== Auth::id(), 403)` in ShippingAddress
5. **C13** — Fix `Builder::raw()` → `DB::raw()` or `whereColumn()` in `Order::shippingAddress()`
6. **I14** — Fix `H:m` → `H:i` in DashboardService (one character, silent wrong data)

### Week 2 — Before Next Release
7. **C9** — Implement PayOS webhook endpoint with HMAC signature verification
8. **C10** — Add `lockForUpdate()` + re-validation in coupon decrement
9. **C7** — Add `lockForUpdate()` in stock decrement
10. **C11** — Restore stock on cancel/delete in OrderController + DeleteOrderAction
11. **C12** — Move `$product->delete()` inside DB transaction
12. **C4** — Validate `quantity` as `integer|min:1` in CartController
13. **C4** — Remove `is_admin`, `email_verified_at` from `$fillable`
14. **I6** — Replace plaintext password email with token reset flow
15. **I7** — Add null guard in all 3 order job handlers
16. **I16** — Add `->where('user_id', Auth::id())` in `wishlist()`

### Week 3 — Code Quality Pass
Remaining Important + Minor items.

---

## Unresolved Questions

1. Is `COMPLETED` order status intentionally excluded from earnings (`getEarningCount`)?
2. Is `is_admin` a legacy field being phased out, or still used alongside `role`? (`isRoot()` checks both)
3. Is `Order::shippingAddress()` relationship used anywhere? If not, remove it.
4. Does `AdminHomeController::profile()` enforce role/permission for `admin/profile/{user}`?
5. Is there a PayOS webhook handler anywhere outside scope (checked `routes/web.php` — not found)?
6. Is there a queue worker retry limit configured? Failed jobs from I7 will loop indefinitely.
