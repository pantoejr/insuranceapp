<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('app.index');
});

Route::controller(PermissionController::class)->group(function () {
    Route::get('/permissions', 'index')->name('permissions.index')->can('view-permissions');
    Route::get('/permissions/create', 'create')->name('permissions.create')->can('add-permission');
    Route::post('/permissions/store', 'store')->name('permissions.store')->can('add-permission');
    Route::get('/permissions/edit/{id}', 'edit')->name('permissions.edit')->can('edit-permission');
    Route::post('/permissions/edit/{id}', 'update')->name('permissions.update')->can('edit-permission');
    Route::get('/permissions/delete/{id}', 'destroy')->name('permissions.destroy')->can('delete-permission');
});

Route::controller(RoleController::class)->group(function () {
    Route::get('/roles', 'index')->name('roles.index')->can('view-roles');
    Route::get('/roles/create', 'create')->name('roles.create')->can('add-role');
    Route::post('/roles/store', 'store')->name('roles.store')->can('add-role');
    Route::get('/roles/details/{id}', 'details')->name('roles.details')->can('view-role-details');
    Route::get('/roles/edit/{id}', 'edit')->name('roles.edit')->can('edit-role');
    Route::post('/roles/edit/{id}', 'update')->name('roles.update')->can('edit-role');
    Route::get('/roles/delete/{id}', 'destroy')->name('roles.destroy')->can('delete-role');
});


Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index')->can('view-users');
    Route::get('/users/create', 'create')->name('users.create')->can('add-user');
    Route::post('/users/store', 'store')->name('users.store')->can('add-user');
    Route::get('/users/edit/{id}', 'edit')->name('users.edit')->can('edit-user');
    Route::post('/users/edit/{id}', 'update')->name('users.update')->can('edit-user');
    Route::post('/users/delete/{id}', 'destroy')->name('users.destroy')->can('delete-user');
    Route::get('/users/details/{id}', 'details')->name('users.details')->can('view-user-details');
    Route::post('/users/refresh-permissions/{id}', 'refreshPermissions')->name('users.refreshPermissions')->can('refresh-user-permissions');
});


Route::controller(EmailSettingController::class)->group(function () {
    Route::get('/email-settings', 'index')->name('email-settings.index');
    Route::get('/email-settings/create', 'create')->name('email-settings.create');
    Route::post('/email-settings/store', 'store')->name('email-settings.store');
    Route::get('/email-settings/edit/{id}', 'edit')->name('email-settings.edit');
    Route::post('/email-settings/edit/{id}', 'update')->name('email-settings.update');
    Route::get('/email-settings/delete/{id}', 'destroy')->name('email-settings.destroy');
    Route::get('/email-settings/details/{id}', 'details')->name('email-settings.details');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::get('/change-password', 'showChangePasswordForm')->name('change-password');
    Route::post('/change-password', 'changePassword')->name('confirm-change-password');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('password/reset', 'reset')->name('password.update');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/clients', 'index')->name('clients.index');
    Route::get('/clients/create/', 'create')->name('clients.create');
    Route::post('/clients/store', 'store')->name('clients.store');
    Route::get('/clients/edit/{id}', 'edit')->name('clients.edit');
    Route::post('/clients/edit/{id}', 'update')->name('clients.update');
    Route::post('/clients/delete/{id}', 'destroy')->name('clients.destroy');
    Route::get('/clients/details/{id}', 'details')->name('clients.details');
    Route::post('/clients/{id}/add-attachment', 'addAttachment')->name('clients.addAttachment');
});

Route::controller(EmployeeController::class)->group(function () {
    Route::get('/employees', 'index')->name('employees.index');
    Route::get('/employees/create/{clientId?}', 'create')->name('employees.create');
    Route::post('/employees/store/{clientId?}', 'store')->name('employees.store');
    Route::get('/employees/edit/{id}/{clientId?}', 'edit')->name('employees.edit');
    Route::post('/employees/edit/{id}/{clientId?}', 'update')->name('employees.update');
    Route::post('/employees/delete/{id}/{clientId?}', 'destroy')->name('employees.destroy');
    Route::get('/employees/details/{id}/{clientId?}', 'details')->name('employees.details');
});

Route::controller(DependentController::class)->group(function () {
    Route::get('/dependents', 'index')->name('dependents.index');
    Route::get('/dependents/create/{employeeId?}', 'create')->name('dependents.create');
    Route::post('/dependents/store/{employeeId?}', 'store')->name('dependents.store');
    Route::get('/dependents/edit/{id}/{employeeId?}', 'edit')->name('dependents.edit');
    Route::post('/dependents/edit/{id}/{employeeId?}', 'update')->name('dependents.update');
    Route::post('/dependents/delete/{id}/{employeeId?}', 'destroy')->name('dependents.destroy');
    Route::get('/dependents/details/{id}/{employeeId?}', 'details')->name('dependents.details');
});

Route::controller(AttachmentController::class)->group(function () {
    Route::get('/attachments', 'index')->name('attachments.index');
    Route::get('/attachments/create', 'create')->name('attachments.create');
    Route::post('/attachments/store', 'store')->name('attachments.store');
    Route::get('/attachments/edit/{id}', 'edit')->name('attachments.edit');
    Route::post('/attachments/edit/{id}', 'update')->name('attachments.update');
    Route::post('/attachments/delete/{id}/{clientId?}', 'destroy')->name('attachments.destroy');
    Route::get('/attachments/details/{id}', 'details')->name('attachments.details');
    Route::get('/attachments/download/{id}', 'download')->name('attachments.download');
});
