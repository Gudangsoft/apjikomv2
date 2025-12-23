<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('member.login');
        }

        $user = auth()->user();

        // Check if user is member by role OR has a member record
        // This handles legacy users who have member records but role wasn't set properly
        if (!$user->isMember() && !$user->member) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Member.');
        }

        // If user has member record but role is not set, fix it automatically
        if ($user->member && !$user->isMember() && $user->role !== 'admin') {
            $user->role = 'member';
            $user->save();
        }

        return $next($request);
    }
}
