<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\SelfController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true, 'register' => true]);

// Route::middleware(['verified'])->group(function () {
// });

Route::group(['prefix' => 'quantri'], function () {
    Route::get('/', function () {
        return redirect('quantri/dashboard');
    });
    Route::get('login', [LoginController::class, 'index'])->name('admin.login');
    Route::get('register', [RegisterController::class, 'index'])->name('admin.register');


    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/load', [DashboardController::class, 'load'])->name('admin.dashboard.load');
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('{key?}/{action?}', [CustomerController::class, 'index'])->name('admin.customer');
        Route::post('create', [CustomerController::class, 'create'])->name('admin.customer.create');
        Route::post('update', [CustomerController::class, 'update'])->name('admin.customer.update');
        Route::post('remove', [CustomerController::class, 'remove'])->name('admin.customer.remove');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('{key?}/{action?}', [OrderController::class, 'index'])->name('admin.order');
        Route::post('create', [OrderController::class, 'create'])->name('admin.order.create');
        Route::post('booking', [OrderController::class, 'booking'])->name('admin.order.booking');
        Route::post('update', [OrderController::class, 'update'])->name('admin.order.update');
        Route::post('remove', [OrderController::class, 'remove'])->name('admin.order.remove');
        Route::post('sync', [OrderController::class, 'sync'])->name('admin.order.sync');
        Route::post('pay', [OrderController::class, 'pay'])->name('admin.order.pay');
        Route::post('paybooking', [OrderController::class, 'paybooking'])->name('admin.order.paybooking');
    });

    Route::group(['prefix' => 'detail'], function () {
        Route::get('{key?}', [DetailController::class, 'index'])->name('admin.detail');
        Route::post('create', [DetailController::class, 'create'])->name('admin.detail.create');
        Route::post('update', [DetailController::class, 'update'])->name('admin.detail.update');
        Route::post('remove', [DetailController::class, 'remove'])->name('admin.detail.remove');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::get('{key?}/{action?}', [TransactionController::class, 'index'])->name('admin.transaction');
        Route::post('create', [TransactionController::class, 'create'])->name('admin.transaction.create');
        Route::post('update', [TransactionController::class, 'update'])->name('admin.transaction.update');
        Route::post('remove', [TransactionController::class, 'remove'])->name('admin.transaction.remove');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('{key?}/{action?}', [UserController::class, 'index'])->name('admin.user');
        Route::post('create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('update', [UserController::class, 'update'])->name('admin.user.update');
        Route::post('update/role', [UserController::class, 'updateRole'])->name('admin.user.update.role');
        Route::post('update/password', [UserController::class, 'updatePassword'])->name('admin.user.update.password');
        Route::post('remove', [UserController::class, 'remove'])->name('admin.user.remove');
        Route::post('/changepassword', [UserController::class, 'changePassword'])->name('admin.user.changepassword');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('{key?}/{action?}', [ProductController::class, 'index'])->name('admin.product');
        Route::post('/sort', [ProductController::class, 'sort'])->name('admin.product.sort');
        Route::post('/save', [ProductController::class, 'save'])->name('admin.product.save');
        Route::post('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::post('remove', [ProductController::class, 'remove'])->name('admin.product.remove');
        Route::post('refill', [ProductController::class, 'refill'])->name('admin.product.refill');
    });

    Route::group(['prefix' => 'catalogue'], function () {
        Route::get('{key?}', [CatalogueController::class, 'index'])->name('admin.catalogue');
        Route::post('/sort', [CatalogueController::class, 'sort'])->name('admin.catalogue.sort');
        Route::post('create', [CatalogueController::class, 'create'])->name('admin.catalogue.create');
        Route::post('update', [CatalogueController::class, 'update'])->name('admin.catalogue.update');
        Route::post('remove', [CatalogueController::class, 'remove'])->name('admin.catalogue.remove');
    });

    Route::group(['prefix' => 'image'], function () {
        Route::get('{key?}', [ImageController::class, 'index'])->name('admin.image');
        Route::post('/upload', [ImageController::class, 'upload'])->name('admin.image.upload');
        Route::post('update', [ImageController::class, 'update'])->name('admin.image.update');
        Route::post('/delete', [ImageController::class, 'delete'])->name('admin.image.delete');
    });

    Route::group(['prefix' => 'work'], function () {
        Route::get('/load', [WorkController::class, 'load'])->name('admin.work.load');
        Route::post('update', [WorkController::class, 'update'])->name('admin.work.update');
        Route::get('management', [WorkController::class, 'management'])->name('admin.work.management');
        Route::get('load-list', [WorkController::class, 'loadList'])->name('work.loadList');
        Route::get('get/{dateSelected?}/{id?}', [WorkController::class, 'get'])->name('admin.work.get');
        Route::post('create', [WorkController::class, 'create'])->name('admin.work.create');
        Route::get('summary', [WorkController::class, 'summary'])->name('admin.work.summary');
        Route::get('/{key?}', [WorkController::class, 'index'])->name('admin.work');
    });

    Route::group(['prefix' => 'branch'], function () {
        Route::get('{key?}', [BranchController::class, 'index'])->name('admin.branch');
        Route::post('create', [BranchController::class, 'create'])->name('admin.branch.create');
        Route::post('update', [BranchController::class, 'update'])->name('admin.branch.update');
        Route::post('remove', [BranchController::class, 'remove'])->name('admin.branch.remove');
    });

    Route::group(['prefix' => 'company'], function () {
        Route::get('{key?}', [CompanyController::class, 'index'])->name('admin.company');
        Route::post('create', [CompanyController::class, 'create'])->name('admin.company.create');
        Route::post('update', [CompanyController::class, 'update'])->name('admin.company.update');
        Route::post('remove', [CompanyController::class, 'remove'])->name('admin.company.remove');
        Route::post('login', [CompanyController::class, 'login'])->name('admin.company.login');
    });

    Route::group(['prefix' => 'table'], function () {
        Route::get('{key?}', [TableController::class, 'index'])->name('admin.table');
        Route::post('create', [TableController::class, 'create'])->name('admin.table.create');
        Route::post('update', [TableController::class, 'update'])->name('admin.table.update');
        Route::post('remove', [TableController::class, 'remove'])->name('admin.table.remove');
    });

    Route::group(['prefix' => 'room'], function () {
        Route::post('load', [RoomController::class, 'load'])->name('admin.room.load');
        Route::get('{key?}', [RoomController::class, 'index'])->name('admin.room');
        Route::post('create', [RoomController::class, 'create'])->name('admin.room.create');
        Route::post('update', [RoomController::class, 'update'])->name('admin.room.update');
        Route::post('remove', [RoomController::class, 'remove'])->name('admin.room.remove');
    });

    Route::group(['prefix' => 'log'], function () {
        Route::get('{key?}', [LogController::class, 'index'])->name('admin.log');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('{key?}', [SelfController::class, 'index'])->name('admin.profile');
        Route::post('change_avatar', [SelfController::class, 'change_avatar'])->name('admin.profile.change_avatar');
        Route::post('change_settings', [SelfController::class, 'change_settings'])->name('admin.profile.change_settings');
        Route::post('change_password', [SelfController::class, 'change_password'])->name('admin.profile.change_password');
        Route::post('change_branch', [SelfController::class, 'change_branch'])->name('admin.profile.change_branch');
        Route::get('timekeeping', [SelfController::class, 'timekeeping'])->name('admin.profile.timekeeping');
        Route::get('timeorder', [SelfController::class, 'timeorder'])->name('admin.profile.timeorder');
        Route::get('timekeeping', [SelfController::class, 'timekeeping'])->name('admin.profile.timekeeping');
        Route::get('timeorder', [SelfController::class, 'timeorder'])->name('admin.profile.timeorder');
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('{key?}', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('image', [SettingController::class, 'updateImage'])->name('admin.setting.image');
        Route::post('pay', [SettingController::class, 'updatePay'])->name('admin.setting.pay');
        Route::post('company', [SettingController::class, 'updateCompany'])->name('admin.setting.company');
        Route::post('email', [SettingController::class, 'updateEmail'])->name('admin.setting.email');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('{key?}', [RoleController::class, 'index'])->name('admin.role');
        Route::post('create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('update', [RoleController::class, 'update'])->name('admin.role.update');
        Route::post('remove', [RoleController::class, 'remove'])->name('admin.role.remove');
    });

    Route::group(['prefix' => 'schedule'], function () {
        Route::get('{key?}', [ScheduleController::class, 'index'])->name('admin.schedule');
        Route::post('create', [ScheduleController::class, 'create'])->name('admin.schedule.create');
        Route::post('update', [ScheduleController::class, 'update'])->name('admin.schedule.update');
        Route::post('remove', [ScheduleController::class, 'remove'])->name('admin.schedule.remove');
    });
});

Route::group(['prefix' => 'work'], function () {
    Route::get('attendance', [WorkController::class, 'attendance'])->name('work.attendance');
});

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'auth'])->name('login.auth');
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('forgot', [ForgotPasswordController::class, 'index'])->name('forgot');

Route::post('/send-email', [ContactController::class, 'sendEmail'])->name('send.email');
