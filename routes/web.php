<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegisterUserController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SittingTableController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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


Route::get('/', [RegistrationController::class, 'index']);

Route::resource('registration', RegistrationController::class);

route::get('/qr-code', function () {
   
});

Route::get('/check-in', [RegistrationController::class, 'checkIn'])->name('check.in');

Route::get('/direct-check-in', [RegistrationController::class, 'directCheckIn'])->name('direct.check.in');

Route::post('/verify-user', [RegistrationController::class, 'verifyUser'])->name('verify.user');

Route::get('/lucky-draw/{registration}', [RegistrationController::class, 'luckyNumber'])->name('lucky.draw');

Route::post('/validate-code', [RegistrationController::class, 'validateCode']);

Route::get('/lucky-draw/view', [RegistrationController::class, 'showLuckyDraw'])->name('lucky-draw.view');


Route::resource('feedback', FeedBackController::class);


Route::get('admin/dashboard', function () {
    return view('backend.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/register-users', [RegisterUserController::class, 'index'])->name('admin.register.users');

    Route::get('register-users-export', [RegisterUserController::class, 'export'])->name('admin.register.users.export');
   
    Route::get('clear-event', [RegisterUserController::class, 'destroy'])->name('admin.clear.event');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/update-css', [SiteSettingController::class, 'updateStyle'])->name('update.css');

    Route::resource('site-setting', SiteSettingController::class);

    Route::resource('sitting-table', SittingTableController::class);

    Route::post('/assign-sitting-table', [SittingTableController::class, 'assignSittingTable'])->name('assign.sitting.table');

    Route::get('/ball-room', [SittingTableController::class, 'ballRoom'])->name('ball.room');

    Route::get('/get-registrations/{tableId}', [SittingTableController::class, 'getRegistrations'])->name('get.registrations');

    Route::get('/all-feedback', [FeedBackController::class, 'allFeedback'])->name('all.feedback');

    Route::get('/preview-page', [RegisterUserController::class, 'previewPage'])->name('preview.page');

    Route::post('/register-users/import', [RegisterUserController::class, 'import'])->name('admin.register.users.import');

});
Route::group(['prefix' => 'd3v-te$t', 'as' => 'd3vte$t.', 'middleware' => ['auth']], function () {
   Route::get('admin/cache-clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    dd(\Illuminate\Support\Facades\Artisan::output());
})->name('admin.cache.clear');
    Route::get('optimize-clear', function () {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('optimize.clear');
    Route::get('check-config', function () {
        dd(config(request('key')));
    })->name('check.config');
    Route::get('migrate-status', function () {
        \Illuminate\Support\Facades\Artisan::call('migrate:status');
        dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('migrate.status');
    Route::get('migrate-db', function () {
        \Illuminate\Support\Facades\Artisan::call('migrate');
        dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('migrate.db');
    Route::get('storage-link', function () {
        // Delete the existing symbolic link
        if (file_exists(public_path('storage'))) {
            unlink(public_path('storage'));
        }
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('storage.link');
    Route::get('app-seed', function () {
            \Illuminate\Support\Facades\Artisan::call("db:seed");
            dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('db.seeding');
     Route::get('app-seed-class', function () {
        ini_set('memory_limit', '512M');
        set_time_limit(600);
        if ($class = request()->get('class')) {
            \Illuminate\Support\Facades\Artisan::call("db:seed --class={$class} --force");
            dd(\Illuminate\Support\Facades\Artisan::output());
        }
        dd('provide seeder class');
    })->name('db.seeding');
    Route::get('app-refresh', function () {
        \Illuminate\Support\Facades\Artisan::call("migrate:fresh --seed");
        dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('db.fresh.seeding');
    Route::get('composer-update', function () {
        \Illuminate\Support\Facades\Artisan::call('composer update');
        dd(\Illuminate\Support\Facades\Artisan::output());
    })->name('migrate-db');



});
require __DIR__ . '/auth.php';
