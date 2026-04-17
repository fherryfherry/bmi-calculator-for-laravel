<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AgentBypassAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('local')) {
            $token = $request->header('x-login-token');
            $secret = env('AGENT_LOGIN_TOKEN');
            if ($token && $secret && hash_equals((string)$secret, (string)$token)) {
                if (!Auth::check()) {
                    $user = User::orderBy('id')->first();
                    if ($user) {
                        Auth::login($user, true);
                        $request->session()->regenerate();
                    }
                }
            }
        }

        return $next($request);
    }
}

