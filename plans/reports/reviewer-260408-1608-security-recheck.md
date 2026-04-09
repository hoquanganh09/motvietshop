# Security Re-check Report
Date: 2026-04-08 | Branch: feature/ui-ux-enhancements

## Fix Verification Results

| # | Fix | File | Status | Notes |
|---|-----|------|--------|-------|
| 1a | `session()->regenerate()` after `Auth::attempt()` — client | `Actions/Client/Auth/LoginAction.php:31` | **Correct** | Called inside the success branch, before `return true` |
| 1b | `session()->regenerate()` after `Auth::attempt()` — admin | `Actions/Admin/Auth/LoginAction.php:28` | **Correct** | Uses `$request->session()->regenerate()` properly |
| 2a | `session()->invalidate() + regenerateToken()` — client logout | `Controllers/Client/AuthController.php:74-75` | **Correct** | Both calls present in `logout()` |
| 2b | `session()->invalidate() + regenerateToken()` — admin logout | `Actions/Admin/Auth/LogoutAction.php:24-25` | **Correct** | Uses `request()->session()` facade, both calls present |
| 3 | `throttle:5,1` on admin login POST | `routes/admin.php:99` | **Correct** | Applied to POST only, GET login page unthrottled (expected) |
| 4a | `is_admin` removed from `User::$fillable` | `Models/User.php:26-38` | **Correct** | Not present in fillable array |
| 4b | `email_verified_at` removed from `User::$fillable` | `Models/User.php:26-38` | **Correct** | Not present in fillable array |
| 5 | `orderSuccess()` scoped to `Auth::id()` | `Controllers/Client/ClientController.php:191-192` | **Correct** | Double-scoped: `user_id` + `payos_order_code` |
| 6a | `ShippingAddress::update` has ownership check | `Controllers/Client/ShippingAddressController.php:27` | **Correct** | `abort_if($shippingAddress->user_id !== Auth::id(), 403)` |
| 6b | `ShippingAddress::destroy` has ownership check | `Controllers/Client/ShippingAddressController.php:36` | **Correct** | Same pattern as update |
| 7 | `CustomGuest`: JSON response gated behind `expectsJson()` | `Middleware/CustomGuest.php:28` | **Correct** | Uses `$request->expectsJson()` |
| 8 | `CustomAuth`: fallback for unknown guard | `Middleware/CustomAuth.php:24-26` | **Correct** | `isset` check + `abort(500, ...)` |
| 9 | `Visitor`: uses `request->is('admin/*')` | `Middleware/Visitor.php:20` | **Correct** | Checks both `'admin'` and `'admin/*'` |
| 10 | `LoginSocialAction`: `is_active = 1` line removed | `Actions/Client/Auth/LoginSocialAction.php` | **Correct** | No `is_active` assignment anywhere in file |
| 11 | `RegisterRequest`: `password` has `min:8` | `Requests/Client/Auth/RegisterRequest.php:27` | **Correct** | Rule: `required\|confirmed\|min:8` |
| 12 | `ForgotPasswordRequest`: `exists:users,email` removed | `Requests/Client/Auth/ForgotPasswordRequest.php:24` | **Correct** | Only `required\|email` — no DB enumeration leak |
| 13a | `AdminUserController::resetPassword` has validation | `Controllers/Admin/UserController.php:97` | **Correct** | `required\|email\|exists:users,email` + `firstOrFail()` |
| 13b | `AdminUserController::resetPassword` has root protection | `Controllers/Admin/UserController.php:102-104` | **Correct** | Blocks non-root from resetting a root account |

---

## Issues Found

### ISSUE-1 — `User::isRoot()` references stale `is_admin` column (Medium)
**File:** `app/Models/User.php:127`
```php
public function isRoot()
{
    return $this->role == Role::ROOT || $this->is_admin == 1;
}
```
`is_admin` was removed from `$fillable` but `isRoot()` still reads it from the model. If the DB column still exists, this is a latent privilege escalation vector: anyone with `is_admin = 1` in the DB is treated as Root even without the `ROOT` role. The column should either be dropped via migration or the `|| $this->is_admin == 1` clause removed.

### ISSUE-2 — `handleRegister()` calls `Auth::login()` without `session()->regenerate()` (High)
**File:** `app/Http/Controllers/Client/AuthController.php:48`
```php
Auth::login($user);
return to_route('client.home.index');
```
Session fixation fix (item #1) was applied to `LoginAction` but not to the registration flow. A session-fixation attack is possible: attacker pre-seeds a session, victim registers, attacker hijacks the new authenticated session. `session()->regenerate()` must be called after `Auth::login($user)`.

### ISSUE-3 — `callbackGoogleLogin()` calls `Auth::login()` without `session()->regenerate()` (High)
**File:** `app/Http/Controllers/Client/AuthController.php:62`
```php
Auth::login($user, true);
return to_route('client.home.index');
```
Same session-fixation gap as ISSUE-2 in the OAuth callback path. `LoginSocialAction` itself was cleaned up (fix #10), but the controller that calls `Auth::login()` directly was not hardened.

### ISSUE-4 — `CustomGuest`: unknown guard causes `KeyError` / null-redirect (Low)
**File:** `app/Http/Middleware/CustomGuest.php:30`
```php
'redirect' => route($redirectGuard[$guard]),
```
If `$guard` is not in `$redirectGuard` (e.g., a typo in route definition), PHP will emit an undefined-index notice and `route(null)` will throw. `CustomAuth` correctly does an `isset` check; `CustomGuest` does not. Add the same guard.

### ISSUE-5 — `StoreUserRequest` allows admin to create accounts with weak password (Low)
**File:** `app/Http/Requests/Admin/User/StoreUserRequest.php:30`
```php
'password' => 'required|string|max:250|min:6',
```
`RegisterRequest` (client) was updated to `min:8`. The admin user creation form is still `min:6`. Inconsistent policy; should align to `min:8`.

---

## Summary

- 13/13 original fixes confirmed **Correct**
- 2 **High** regressions found (ISSUE-2, ISSUE-3): session fixation still possible via register and social login paths
- 1 **Medium** issue (ISSUE-1): `is_admin` ghost-column logic in `isRoot()` undermines the fillable fix
- 2 **Low** issues (ISSUE-4, ISSUE-5): CustomGuest guard safety + weak admin password policy

---

## Unresolved Questions
- Is the `is_admin` DB column intended to be removed entirely? If yes, a migration dropping it is required to fully close ISSUE-1.
- Should `callbackGoogleLogin` also verify `isActive()` before logging in? Currently an inactive Google-linked account can log in.
