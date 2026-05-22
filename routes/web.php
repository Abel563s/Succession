<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/projects/closeout', [\App\Http\Controllers\ProjectController::class, 'closeoutIndex'])->name('projects.closeout.index');
        Route::get('/projects/{project}/closeout', [\App\Http\Controllers\ProjectController::class, 'closeoutShow'])->name('projects.closeout.show');
        Route::get('/projects/analytics', [\App\Http\Controllers\ProjectController::class, 'analytics'])->name('projects.analytics');

        Route::get('/projects/payments', [\App\Http\Controllers\Admin\ProjectPaymentController::class, 'index'])->name('projects.payments.index');
        Route::get('/projects/{project}/payments', [\App\Http\Controllers\Admin\ProjectPaymentController::class, 'manage'])->name('projects.payments.manage');
        Route::post('/projects/{project}/payments', [\App\Http\Controllers\Admin\ProjectPaymentController::class, 'store'])->name('projects.payments.store');
        Route::get('/payments/{payment}', [\App\Http\Controllers\Admin\ProjectPaymentController::class, 'show'])->name('projects.payments.show');

        Route::resource('projects', \App\Http\Controllers\ProjectController::class);
        Route::resource('progress-updates', \App\Http\Controllers\Admin\ProjectProgressUpdateController::class);
        Route::resource('weekly-updates', \App\Http\Controllers\Admin\ProjectWeeklyUpdateController::class);

        Route::get('/settings', [SystemSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SystemSettingController::class, 'updateSetting'])->name('settings.update');
        Route::patch('/settings/profile', [SystemSettingController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/settings/password', [SystemSettingController::class, 'updatePassword'])->name('settings.password.update');

        Route::resource('users', AdminUserController::class);
        Route::get('/roles', [AdminUserController::class, 'index'])->name('roles.index');
        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

        Route::post('/approve/{module}/{id}', [\App\Http\Controllers\Admin\ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/reject/{module}/{id}', [\App\Http\Controllers\Admin\ApprovalController::class, 'reject'])->name('approval.reject');
    });

    Route::middleware(['role:admin|manager|user'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('critical-roles', \App\Http\Controllers\Admin\CriticalRoleController::class);
        Route::resource('successions', \App\Http\Controllers\Admin\SuccessionController::class);
        Route::resource('nine-box', \App\Http\Controllers\Admin\NineBoxController::class);
        Route::resource('development', \App\Http\Controllers\Admin\DevelopmentController::class);
        Route::resource('training', \App\Http\Controllers\Admin\TrainingController::class);
        Route::resource('mentor', \App\Http\Controllers\Admin\MentorController::class);
        Route::resource('coaching', \App\Http\Controllers\Admin\CoachingController::class);
        Route::resource('progress', \App\Http\Controllers\Admin\ProgressController::class);
        Route::resource('sd', \App\Http\Controllers\Admin\SuccessionDashboardController::class);
        Route::resource('leadership', \App\Http\Controllers\Admin\LeadershipController::class);
        Route::resource('transition', \App\Http\Controllers\Admin\TransitionController::class);
    });

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');

    Route::middleware(['role:admin|MaterialTracker'])
        ->prefix('material-tracker')
        ->name('material-tracker.')
        ->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\MaterialTracker\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('/materials', \App\Http\Controllers\MaterialTracker\MaterialController::class);
        });
});
