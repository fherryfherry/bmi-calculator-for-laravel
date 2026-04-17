<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/agent/navigation', function (Request $request) {
    abort_unless(app()->environment(['local', 'development']), 403);

    $token = (string) $request->header('x-login-token', '');
    $secret = (string) env('AGENT_LOGIN_TOKEN', '');
    abort_unless($token !== '' && $secret !== '' && hash_equals($secret, $token), 403);

    $normalizePath = static function (?string $value): string {
        $raw = trim((string) $value);
        if ($raw === '' || $raw === '/') {
            return '/';
        }

        return '/' . ltrim($raw, '/');
    };

    $shouldIncludePath = static function (string $path): bool {
        $normalized = preg_replace('/[?#].*$/', '', $path) ?: '/';
        if ($normalized === '/up') {
            return false;
        }
        if ($normalized === '/api' || Str::startsWith($normalized, '/api/')) {
            return false;
        }
        if (Str::startsWith($normalized, '/_ignition') || Str::startsWith($normalized, '/sanctum')) {
            return false;
        }
        if (Str::contains($normalized, ['{', '}'])) {
            return false;
        }

        return true;
    };

    $buildLabel = static function (string $path): string {
        if ($path === '/') {
            return 'Home';
        }

        $segments = collect(explode('/', trim($path, '/')))
            ->filter()
            ->map(fn (string $segment) => Str::headline(str_replace(['-', '_'], ' ', $segment)))
            ->values();

        return $segments->implode(' > ');
    };

    $items = collect(Route::getRoutes()->getRoutes())
        ->filter(function ($route) {
            $methods = collect($route->methods())->map(fn ($method) => strtoupper((string) $method));
            return $methods->contains('GET') || $methods->contains('HEAD');
        })
        ->map(function ($route) use ($normalizePath, $shouldIncludePath, $buildLabel) {
            $path = $normalizePath($route->uri());
            if (! $shouldIncludePath($path)) {
                return null;
            }

            $label = $buildLabel($path);

            return [
                'path' => $path,
                'route_name' => $route->getName() ?: '',
                'label' => $label,
                'group' => Str::before($label, ' > ') ?: $label,
            ];
        })
        ->filter()
        ->unique('path')
        ->sortBy(fn (array $item) => ($item['path'] === '/' ? '0' : '1') . '|' . $item['group'] . '|' . $item['path'])
        ->values();

    return response()->json([
        'items' => $items,
    ]);
});

Route::get('/agent/auto-login-url', function (Request $request) {
    abort_unless(app()->environment(['local', 'development']), 403);

    $token = (string) $request->header('x-login-token', '');
    $secret = (string) env('AGENT_LOGIN_TOKEN', '');
    abort_unless($token !== '' && $secret !== '' && hash_equals($secret, $token), 403);

    $targetPath = '/' . ltrim((string) $request->query('target_path', '/admin/dashboard'), '/');
    $targetPath = preg_replace('#/+#', '/', $targetPath) ?: '/admin/dashboard';
    if ($targetPath === '' || ! Str::startsWith($targetPath, '/admin') || Str::contains($targetPath, '..')) {
        $targetPath = '/admin/dashboard';
    }

    $expires = now()->addMinutes(2)->timestamp;
    $payload = $targetPath . '|' . $expires;
    $signature = hash_hmac('sha256', $payload, $secret);
    $query = http_build_query([
        'target_path' => $targetPath,
        'expires' => $expires,
        'signature' => $signature,
    ]);

    $path = '/admin/agent/auto-login?' . $query;

    return response()->json([
        'path' => $path,
        'expires' => $expires,
    ]);
});
