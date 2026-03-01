<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * PermissionMiddleware
 *
 * Verifies that the authenticated user has permission
 * to access the requested route. Super admins bypass
 * all permission checks. Also handles forced user logout.
 *
 * @author Mohammed Belmekki
 */
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Super admins bypass all permission checks
        if ($request->user()->is_super_admin) {
            return $next($request);
        }

        $routeName = $request->route()->getName();

        if (!$request->user()->can($routeName)) {
            // Log unauthorized access attempts for security auditing
            Log::warning('Unauthorized access attempt', [
                'user_id'    => $request->user()->id,
                'username'   => $request->user()->username,
                'route'      => $routeName,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. You do not have permission to perform this action.',
                ], 401);
            }
            abort(401);
        }

        // Check for user force logout flag
        if ($request->user()->force_logout) {
            $request->user()->force_logout = 0;
            $request->user()->save();

            Log::info('User force logged out', [
                'user_id'  => $request->user()->id,
                'username' => $request->user()->username,
            ]);

            Auth::logout();
            return redirect()->route('login');
        }

        return $next($request);
    }
}
