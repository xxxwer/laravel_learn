<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'fail',
                    'reason' => '请重新登录'
                ]);
            } else {
                return redirect()->route('Admin::login');
            }
        }

        return $next($request);
    }
}
