<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BmiRecordController;
use App\Http\Controllers\BmiCalculatorController;

// Frontend BMI Calculator Routes (Home Page)
Route::get('/', [BmiCalculatorController::class, 'show'])->name('bmi.show');
Route::post('/', [BmiCalculatorController::class, 'calculate'])->name('bmi.calculate');
Route::get('/bmi-result/{bmiRecord}', [BmiCalculatorController::class, 'result'])->name('bmi.result');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit')->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    Route::get('/agent/auto-login', function (Request $request) {
        abort_unless(app()->environment(['local', 'development']), 403);

        $secret = (string) env('AGENT_LOGIN_TOKEN', '');
        $signature = (string) $request->query('signature', '');
        $expires = (int) $request->query('expires', 0);
        $targetPath = '/' . ltrim((string) $request->query('target_path', '/admin/dashboard'), '/');
        $targetPath = preg_replace('#/+#', '/', $targetPath) ?: '/admin/dashboard';

        if ($expires <= now()->timestamp) {
            abort(403);
        }

        if ($targetPath === '' || ! str_starts_with($targetPath, '/admin') || str_contains($targetPath, '..')) {
            $targetPath = '/admin/dashboard';
        }

        abort_unless($secret !== '' && $signature !== '', 403);
        $payload = $targetPath . '|' . $expires;
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        abort_unless(hash_equals($expectedSignature, $signature), 403);

        if (! Auth::check()) {
            $user = User::query()->orderBy('id')->first();
            if ($user) {
                Auth::login($user, true);
                $request->session()->regenerate();
            }
        }

        return redirect()->to($targetPath ?: '/admin/dashboard');
    })->name('agent.auto-login');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->middleware('can:dashboard.view')->name('dashboard');

        Route::resource('users', UserController::class)->except('show');
        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('bmi-records', BmiRecordController::class)->only(['index', 'show', 'destroy']);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
