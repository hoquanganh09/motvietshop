# Security & Auth Review — motvietshop

**Date:** 2026-04-08
**Scope:** Middleware, Auth Controllers, Form Requests, User model, Routes
**Branch:** feature/ui-ux-enhancements

---

## Critical Issues

### 1. Session fixation — no regeneration after login
**Files:** `app/Actions/Client/Auth/LoginAction.php:30`, `app/Actions/Admin/Auth/LoginAction.php:27`

Neither login action calls `session()->regenerate()` after `Auth::attempt()`. Attacker who plants a known session ID (e.g. via XSS or network sniff before login) retains access post-authentication.

Fix: add `request()->session()->regenerate();` immediately after a successful attempt.

### 2. Session not invalidated on logout
**Files:** `app/Http/Controllers/Client/AuthController.php:71-75`, `app/Actions/Admin/Auth/LogoutAction.php`

Client logout: `Auth::logout()` only. Admin logout: same. Neither calls `session()->invalidate()` + `session()->regenerateToken()`. Old session tokens remain valid until they expire, enabling session replay.

Fix (both logout paths):
```php
Auth::guard($guard)->logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
```

### 3. Admin login has no rate limiting
**File:** `routes/admin.php` — `POST /admin/dang-nhap`

Client login has `throttle:10,1`. Admin login has none at all, enabling unlimited brute-force against admin credentials.

Fix: add `->middleware('throttle:5,1')` to `admin.auth.handleLogin`.

### 4. `is_admin` is mass-assignable on User model
**File:** `app/Models/User.php:38`

`is_admin` is in `$fillable`. `StoreUserRequest` passes `$request->validated()` directly to `User::create()`. Although `StoreUserRequest` doesn't include `is_admin` as a validated field, any future expansion or forgotten validation gap would silently allow privilege escalation. `email_verified_at` and `role` are also fillable — if validation ever slips, an attacker-controlled `role=1` (ROOT) can be submitted.

Fix: remove `is_admin` and `email_verified_at` from `$fillable`; set them explicitly in code.

---

## Important Issues

### 5. `CustomGuest` middleware has dead `to_route()` after a `return`
**File:** `app/Http/Middleware/CustomGuest.php:28-33`

```php
return response()->json([...], 401);   // always returns here
return to_route($redirectGuard[$guard]); // unreachable
```
Authenticated web users hitting a guest-only page (login/register) get a raw 401 JSON response instead of a redirect. This is a UX break for non-AJAX requests (direct browser navigation) and means the browser lands on a JSON blob.

Fix: mirror `CustomAuth` — check `$request->ajax()` first; only return JSON for AJAX; `to_route()` for normal requests.

### 6. Forgot-password endpoint leaks account existence
**File:** `app/Http/Requests/Client/Auth/ForgotPasswordRequest.php:25`

Rule: `'email' => 'required|email|exists:users,email'`. Validation failure reveals whether an email is registered. The job itself also silently skips unverified accounts (`isEmailVerified()`), so the behavior is inconsistent with the 422 validation error.

Fix: remove `exists:users,email`; always return success ("if account exists you'll receive an email") and handle the no-account case silently inside the job.

### 7. `AdminUserController::resetPassword` accepts unvalidated raw input
**File:** `app/Http/Controllers/Admin/UserController.php:95-99`

```php
public function resetPassword(Request $request)
{
    SendMailForgotPasswordJon::dispatch($request->email);
```
No `FormRequest`, no validation at all. `$request->email` is sent directly to the job which queries the DB. A missing/null email won't crash (the `where` will return nothing) but there's no CSRF-independent validation and no authorization check beyond being any admin — even a low-privilege admin can trigger password resets for any user including ROOT.

Fix: add a dedicated `FormRequest` with `email|required|email|exists:users,email`; add role-level authorization.

### 8. `updateActive` accepts arbitrary `status` value without validation
**File:** `app/Http/Controllers/Admin/UserController.php:120-128`

```php
$user->update(['is_active' => $request->status]);
```
No `FormRequest`; `$request->status` is passed directly. Any integer (or string) can be written into `is_active`. Should use `validate(['status' => 'required|boolean'])`.

### 9. Shipping address: no ownership check on update/destroy
**File:** `app/Http/Controllers/Client/ShippingAddressController.php:24-45`

`update(ShippingAddress $shippingAddress)` and `destroy(ShippingAddress $shippingAddress)` use route model binding but never verify `$shippingAddress->user_id === Auth::id()`. Any authenticated user can update or delete another user's shipping address by guessing the ID.

Fix: add `abort_if($shippingAddress->user_id !== Auth::id(), 403)` in both methods, or use a Policy.

### 10. Social login force-activates any existing account
**File:** `app/Actions/Client/Auth/LoginSocialAction.php:34`

```php
$user->is_active = 1;
$user->save();
```
If an admin has deactivated a user, OAuth login bypasses that ban by unconditionally setting `is_active = 1`. The `LoginAction` checks `isActive()`, but `LoginSocialAction` then re-activates before `Auth::login()` in the controller.

Fix: remove the `$user->is_active = 1` line; if account is inactive, throw an exception or return null so the controller redirects to an error.

### 11. Register: no password minimum length rule
**File:** `app/Http/Requests/Client/Auth/RegisterRequest.php:25`

`'password' => 'required|confirmed'` — no `min:8` (or any minimum). A 1-character password is accepted. `StoreUserRequest` has `min:6`; they should be consistent and stronger (min:8 recommended).

---

## Minor Issues

### 12. `ChangePassword` — `current_password` is nullable
**File:** `app/Http/Requests/Client/User/ChangePassword.php:27`

`'current_password' => 'nullable|...|current_password:web'` — the `current_password` rule only fires when the field is present and non-null. The intent seems to be to allow social-login users (who have no password) to set one, but this should be explicitly conditioned, e.g., `required_without:provider` or handled in the action, not left as a nullable bypass.

### 13. Review `arr.*.note` has no max length
**File:** `app/Http/Requests/Client/Review/StoreReviewRequest.php:28`

`'arr.*.note' => 'nullable|string'` — no `max`. A single request could store an arbitrarily large string in the reviews table.

Fix: add `max:2000`.

### 14. `Visitor` middleware: URL check is string-match, not path-prefix
**File:** `app/Http/Middleware/Visitor.php:20`

`str_contains($request->url(), 'admin')` — matches any URL with "admin" anywhere (e.g. a product slug "vitamin-supplement-admin-pack" would not be counted, but "admin" in query params would bypass intent). Use `$request->is('admin/*')` instead.

### 15. `CustomAuth` redirectGuard array: no fallback for unknown guard
**File:** `app/Http/Middleware/CustomAuth.php:19-22`

If called with an unregistered guard (typo in route), `$redirectGuard[$guard]` will throw `Undefined array key`. Add a null-safe fallback or use `array_key_exists` check.

---

## Summary

| Severity | Count |
|----------|-------|
| Critical | 4 |
| Important | 7 |
| Minor | 4 |

**Top 3 to fix first:**
1. Session fixation + logout invalidation (Critical, trivial fix)
2. Admin login brute-force (Critical, one line)
3. Shipping address IDOR (Important, data exposure)
