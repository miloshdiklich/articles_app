<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
	public function handle(Request $request, Closure $next, $roles)
	{
		$role = Auth::guard('sanctum')->user()->role->name;
		$rolesArray = explode("|", $roles);
		if (in_array($role, $rolesArray)) {
			return $next($request);
		}
		return response(['message' => 'Unauthorized.'], 403);
	}
}
