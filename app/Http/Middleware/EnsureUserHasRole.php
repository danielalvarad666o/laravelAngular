<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     * @param  string  $role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
      * @return mixed
     */
    public function handle(Request $request, Closure $next,...$role )
    {
      if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);

    }
    $user = $request->user();

      if ($user->status !== 1) {
        return response()->json(['error' => 'Session is closed'], 401);
    }

    if (!$user->validaciondelrol($role)) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
      return $next ($request);
      
     
    }
}
