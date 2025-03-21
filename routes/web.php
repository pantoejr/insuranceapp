<?php

use App\Http\Controllers\AssignPolicyController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InsurerAssignmentController;
use App\Http\Controllers\InsurerController;
use App\Http\Controllers\InsurerPolicyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PolicyAssignmentController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemVariableController;
use App\Http\Controllers\UserController;
use App\Models\Policy;
use App\Models\PolicyAssignment;
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
    Route::get('/clients', 'index')->name('clients.index')->can('view-clients');
    Route::get('/clients/create/', 'create')->name('clients.create')->can('add-client');
    Route::post('/clients/store', 'store')->name('clients.store')->can('add-client');
    Route::get('/clients/edit/{id}', 'edit')->name('clients.edit')->can('edit-client');
    Route::post('/clients/edit/{id}', 'update')->name('clients.update')->can('edit-client');
    Route::post('/clients/delete/{id}', 'destroy')->name('clients.destroy')->can('delete-client');
    Route::get('/clients/details/{id}', 'details')->name('clients.details')->can('view-client-details');
    Route::post('/clients/{id}/add-attachment', 'addAttachment')->name('clients.addAttachment')->can('add-client-attachment');
});

Route::prefix('clients/{client}')->group(function () {
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employees', 'index')->name('employees.index')->can('view-employees');
        Route::get('/employees/create', 'create')->name('employees.create')->can('add-employee');
        Route::post('/employees/store', 'store')->name('employees.store')->can('add-employee');
        Route::get('/employees/edit/{employee}', 'edit')->name('employees.edit')->can('edit-employee');
        Route::post('/employees/edit/{employee}', 'update')->name('employees.update')->can('edit-employee');
        Route::post('/employees/delete/{employee}', 'destroy')->name('employees.destroy')->can('edit-employee');
        Route::get('/employees/details/{employee}', 'details')->name('employees.details')->can('view-employee-details');
        Route::post('/employees/{employee}/add-attachment', 'addAttachment')->name('employee.addAttachment')->can('add-employee-attachment');
    });
});

Route::prefix('employees/{employee}')->group(function () {
    Route::controller(DependentController::class)->group(function () {
        Route::get('/dependents', 'index')->name('dependents.index')->can('view-dependents');
        Route::get('/dependents/create', 'create')->name('dependents.create');
        Route::post('/dependents/store', 'store')->name('dependents.store');
        Route::get('/dependents/edit/{dependent}', 'edit')->name('dependents.edit');
        Route::post('/dependents/edit/{dependent}', 'update')->name('dependents.update');
        Route::post('/dependents/delete/{dependent}', 'destroy')->name('dependents.destroy');
        Route::get('/dependents/details/{dependent}', 'details')->name('dependents.details');
        Route::post('/dependents/{dependent}/add-attachment', 'addAttachment')->name('dependents.addAttachment');
    });
});

Route::controller(AttachmentController::class)->group(function () {
    Route::get('/attachments', 'index')->name('attachments.index');
    Route::get('/attachments/create', 'create')->name('attachments.create');
    Route::post('/attachments/store', 'store')->name('attachments.store');
    Route::get('/attachments/edit/{id}', 'edit')->name('attachments.edit');
    Route::post('/attachments/edit/{id}', 'update')->name('attachments.update');
    Route::post('/attachments/delete/{id}/{clientId?}/{employeeId?}/{dependentId?}', 'destroy')->name('attachments.destroy');
    Route::get('/attachments/details/{id}', 'details')->name('attachments.details');
    Route::get('/attachments/download/{id}', 'download')->name('attachments.download');
});

Route::controller(InsurerController::class)->group(function () {
    Route::get('/insurers', 'index')->name('insurers.index');
    Route::get('/insurers/create', 'create')->name('insurers.create');
    Route::post('/insurers/store', 'store')->name('insurers.store');
    Route::get('/insurers/edit/{id}', 'edit')->name('insurers.edit');
    Route::post('/insurers/edit/{id}', 'update')->name('insurers.update');
    Route::post('/insurers/delete/{id}', 'destroy')->name('insurers.destroy');
    Route::get('/insurers/details/{id}', 'details')->name('insurers.details');
    Route::get('/insurers/editPolicy/{id}', 'editPolicy')->name('insurers.editPolicy');
    Route::post('/insurers/editPolicy/{id}', 'updatePolicy')->name('insurers.updatePolicy');
    Route::post('/insurers/addInsurerUser', 'addInsurerUser')->name('insurers.addInsurerUser');
    Route::get('/insurers/editInsurerUser/{id}', 'editInsurerUser')->name('insurers.editInsurerUser');
    Route::post('/insurers/editInsurerUser/{id}', 'updateInsurerUser')->name('insurers.updateInsurerUser');
});

Route::prefix('/insurers/{insurer}')->group(function () {
    Route::controller(InsurerAssignmentController::class)->group(function () {
        Route::get('/insurer-assignments', 'index')->name('insurer-assignments.index');
        Route::get('/insurer-assignments/create', 'create')->name('insurer-assignments.create');
        Route::post('/insurer-assignments/store', 'store')->name('insurer-assignments.store');
        Route::get('/insurer-assignments/edit/{insurerAssignment}', 'edit')->name('insurer-assignments.edit');
        Route::post('/insurer-assignments/edit/{insurerAssignment}', 'update')->name('insurer-assignments.update');
        Route::post('/insurer-assignments/delete/{insurerAssignment}', 'destroy')->name('insurer-assignments.destroy');
        Route::get('/insurer-assignments/details/{insurerAssignment}', 'details')->name('insurer-assignments.details');
    });
});


Route::controller(InsurerPolicyController::class)->group(function () {
    Route::get('/insurer-policies', 'index')->name('insurer-policies.index');
    Route::get('/insurer-policies/create', 'create')->name('insurer-policies.create');
    Route::post('/insurer-policies/store', 'store')->name('insurer-policies.store');
    Route::get('/insurer-policies/edit/{id}', 'edit')->name('insurer-policies.edit');
    Route::post('/insurer-policies/edit/{id}', 'update')->name('insurer-policies.update');
    Route::post('/insurer-policies/delete/{id}', 'destroy')->name('insurer-policies.destroy');
});

Route::controller(PolicyController::class)->group(function () {
    Route::get('/policies', 'index')->name('policies.index');
    Route::get('/policies/create', 'create')->name('policies.create');
    Route::post('/policies/store', 'store')->name('policies.store');
    Route::get('/policies/edit/{id}', 'edit')->name('policies.edit');
    Route::post('/policies/edit/{id}', 'update')->name('policies.update');
    Route::post('/policies/delete/{id}', 'destroy')->name('policies.destroy');
    Route::get('/policies/details/{id}', 'details')->name('policies.details');
    Route::get('/policies/get-insurer-policies/{id}', 'getInsurerPolicy')->name('policies.getInsurerPolicy');
});

Route::prefix('/clients/{client}')->group(function () {
    Route::controller(PolicyAssignmentController::class)->group(function () {
        Route::get('/client-policies/create', 'create')->name('client-policies.create');
        Route::post('/client-policies/create', 'store')->name('client-policies.store');
    });
});

Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index')->name('invoices.index');
    Route::get('/invoices/create', 'create')->name('invoices.create');
    Route::post('/invoices/create', 'store')->name('invoices.store');
    Route::get('/invoices/edit/{id}', 'edit')->name('invoices.edit');
    Route::post('/invoices/edit/{id}', 'update')->name('invoices.update');
    Route::get('/invoices/details/{id}', 'details')->name('invoices.details');
    Route::get('/invoices/delete/{id}', 'destroy')->name('invoices.destroy');
    Route::get('/invoices/download/{id}', 'download')->name('invoices.download');
    Route::get('invoices/{id}/send-email', 'sendEmail')->name('invoices.sendEmail');
    Route::put('invoices/{id}/update-status', 'updateStatus')->name('invoices.updateStatus');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/payments', 'index')->name('payments.index');
    Route::get('/payments/create', 'create')->name('payments.create');
    Route::post('/payments/create', 'store')->name('payments.store');
    Route::get('/payments/edit/{id}', 'edit')->name('payments.edit');
    Route::post('/payments/edit/{id}', 'update')->name('payments.update');
    Route::get('/payments/details/{id}', 'details')->name('payments.details');
    Route::post('/payments/delete/{id}', 'destroy')->name('payments.destroy');
});


Route::controller(SystemVariableController::class)->group(function () {
    Route::get('/system-variables', 'index')->name('system-variables.index');
    Route::get('/system-variables/create', 'create')->name('system-variables.create');
    Route::post('/system-variables/create', 'store')->name('system-variables.store');
    Route::get('/system-variables/edit/{id}', 'edit')->name('system-variables.edit');
    Route::post('/system-variables/edit/{id}', 'update')->name('system-variables.update');
    Route::get('/system-variables/details/{id}', 'details')->name('system-variables.details');
    Route::post('/system-variables/delete/{id}', 'destroy')->name('system-variables.destroy');
});

Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');

Route::controller(AssignPolicyController::class)->group(function () {
    Route::get('/assign-policy', 'index')->name('assign-policy.index');
    Route::get('/assign-policy/create', 'create')->name('assign-policy.create');
    Route::post('/assign-policy/create', 'store')->name('assign-policy.store');
    Route::get('/assign-policy/edit/{id}', 'edit')->name('assign-policy.edit');
    Route::post('/assign-policy/edit/{id}', 'update')->name('assign-policy.update');
    Route::post('/assign-policy/delete/{id}', 'destroy')->name('assign-policy.destroy');
    Route::get('/assign-policy/details/{id}', 'details')->name('assign-policy.details');
    Route::get('/assign-policy/getInsurerPolicies/{insurer_id}', 'getInsurerPolicies')->name('assign-policy.getInsurerPolicies');
    Route::get('/assign-policy/getPolicyDetails/{policy_id}', 'getPolicyDetails');
});
