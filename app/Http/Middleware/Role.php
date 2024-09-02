<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isAdministrator = User::where('id', auth()->id())->first()->is_admin ?? false;
        // add val to $request
        $request->merge(['isAdministrator' => $isAdministrator]);
        return $next($request);
    }
}
