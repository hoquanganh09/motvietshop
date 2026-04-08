<?php

namespace App\Http\Middleware;

use App\Models\Visitor as ModelsVisitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('admin') && !$request->is('admin/*')) {
            // Fix #7: Dedup Visitor theo IP + Ngày
            // Trước đây mỗi request đều tạo mới 1 bản ghi, 1 người F5 10 lần = 10 visitor
            // Giờ mỗi IP chỉ được đếm 1 lần/ngày, dùng Cache để tránh DB hit liên tục
            $ip      = $request->ip();
            $today   = now()->toDateString();
            $cacheKey = "visitor_{$ip}_{$today}";

            if (!Cache::has($cacheKey)) {
                $alreadyRecorded = ModelsVisitor::whereDate('created_at', $today)
                    ->where('ip', $ip)
                    ->exists();

                if (!$alreadyRecorded) {
                    ModelsVisitor::create([
                        'ip'         => $ip,
                        'user_agent' => $request->userAgent(),
                    ]);
                }

                // Cache trong 24h để tránh query DB mỗi request
                Cache::put($cacheKey, true, 86400);
            }
        }

        return $next($request);
    }
}
