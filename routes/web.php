<?php

use App\Http\Controllers\AssignPolicyController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClaimController;
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
    Route::get('/email-settings', 'index')->name('email-settings.index')->can('view-email-settings');
    Route::get('/email-settings/create', 'create')->name('email-settings.create')->can('add-email-setting');
    Route::post('/email-settings/store', 'store')->name('email-settings.store')->can('add-email-setting');
    Route::get('/email-settings/edit/{id}', 'edit')->name('email-settings.edit')->can('edit-email-setting');
    Route::post('/email-settings/edit/{id}', 'update')->name('email-settings.update')->can('edit-email-setting');
    Route::get('/email-settings/delete/{id}', 'destroy')->name('email-settings.destroy')->can('delete-email-setting');
    Route::get('/email-settings/details/{id}', 'details')->name('email-settings.details')->can('view-email-setting-details');
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
        Route::get('/dependents/create', 'create')->name('dependents.create')->can('add-dependent');
        Route::post('/dependents/store', 'store')->name('dependents.store')->can('add-dependent');
        Route::get('/dependents/edit/{dependent}', 'edit')->name('dependents.edit')->can('edit-dependent');
        Route::post('/dependents/edit/{dependent}', 'update')->name('dependents.update')->can('edit-dependent');
        Route::post('/dependents/delete/{dependent}', 'destroy')->name('dependents.destroy')->can('delete-dependent');
        Route::get('/dependents/details/{dependent}', 'details')->name('dependents.details')->can('view-dependent-details');
        Route::post('/dependents/{dependent}/add-attachment', 'addAttachment')->name('dependents.addAttachment')->can('add-dependent-attachment');
    });
});

Route::controller(AttachmentController::class)->group(function () {
    Route::get('/attachments', 'index')->name('attachments.index')->can('view-attachments');
    Route::get('/attachments/create', 'create')->name('attachments.create')->can('add-attachment');
    Route::post('/attachments/store', 'store')->name('attachments.store')->can('add-attachment');
    Route::get('/attachments/edit/{id}', 'edit')->name('attachments.edit')->can('edit-attachment');
    Route::post('/attachments/edit/{id}', 'update')->name('attachments.update')->can('edit-attachment');
    Route::post('/attachments/delete/{id}/{clientId?}/{employeeId?}/{dependentId?}', 'destroy')->name('attachments.destroy')->can('delete-attachment');
    Route::get('/attachments/details/{id}', 'details')->name('attachments.details')->can('view-attachment-details');
    Route::get('/attachments/download/{id}', 'download')->name('attachments.download')->can('download-attachment');
});

Route::controller(InsurerController::class)->group(function () {
    Route::get('/insurers', 'index')->name('insurers.index')->can('view-insurers');
    Route::get('/insurers/create', 'create')->name('insurers.create')->can('add-insurer');
    Route::post('/insurers/store', 'store')->name('insurers.store')->can('add-insurer');
    Route::get('/insurers/edit/{id}', 'edit')->name('insurers.edit')->can('edit-insurer');
    Route::post('/insurers/edit/{id}', 'update')->name('insurers.update')->can('edit-insurer');
    Route::post('/insurers/delete/{id}', 'destroy')->name('insurers.destroy')->can('delete-insurer');
    Route::get('/insurers/details/{id}', 'details')->name('insurers.details')->can('view-insurer-details');
    Route::get('/insurers/editPolicy/{id}', 'editPolicy')->name('insurers.editPolicy')->can('edit-insurer-policy');
    Route::post('/insurers/editPolicy/{id}', 'updatePolicy')->name('insurers.updatePolicy')->can('edit-insurer-policy');
    Route::post('/insurers/addInsurerUser', 'addInsurerUser')->name('insurers.addInsurerUser')->can('add-insurer-user');
    Route::get('/insurers/editInsurerUser/{id}', 'editInsurerUser')->name('insurers.editInsurerUser')->can('edit-insurer-user');
    Route::post('/insurers/editInsurerUser/{id}', 'updateInsurerUser')->name('insurers.updateInsurerUser')->can('edit-insurer-user');
    Route::post('/insurers/store-multiple-policies', 'storeMultiplePolicies')->name('insurers.storeMultiplePolicies')->can('add-multiple-policies');
    Route::post('/insurers/remove-policy/{id}/{insurerId}', 'removeInsurerPolicy')->name('insurers.removeInsurerPolicy')->can('remove-policy');
});

Route::prefix('/insurers/{insurer}')->group(function () {
    Route::controller(InsurerAssignmentController::class)->group(function () {
        Route::get('/insurer-assignments', 'index')->name('insurer-assignments.index')->can('view-insurer-assignments');
        Route::get('/insurer-assignments/create', 'create')->name('insurer-assignments.create')->can('add-insurer-assignment');
        Route::post('/insurer-assignments/store', 'store')->name('insurer-assignments.store')->can('add-insurer-assignment');
        Route::get('/insurer-assignments/edit/{insurerAssignment}', 'edit')->name('insurer-assignments.edit')->can('edit-insurer-assignment');
        Route::post('/insurer-assignments/edit/{insurerAssignment}', 'update')->name('insurer-assignments.update')->can('edit-insurer-assignment');
        Route::post('/insurer-assignments/delete/{insurerAssignment}', 'destroy')->name('insurer-assignments.destroy')->can('delete-insurer-assignment');
        Route::get('/insurer-assignments/details/{insurerAssignment}', 'details')->name('insurer-assignments.details')->can('view-insurer-assignment-details');
    });
});


Route::controller(InsurerPolicyController::class)->group(function () {
    Route::get('/insurer-policies', 'index')->name('insurer-policies.index')->can('view-insurer-policies');
    Route::get('/insurer-policies/create', 'create')->name('insurer-policies.create')->can('add-insurer-policy');
    Route::post('/insurer-policies/store', 'store')->name('insurer-policies.store')->can('add-insurer-policy');
    Route::get('/insurer-policies/edit/{id}', 'edit')->name('insurer-policies.edit')->can('edit-insurer-policy');
    Route::post('/insurer-policies/edit/{id}', 'update')->name('insurer-policies.update')->can('edit-insurer-policy');
    Route::post('/insurer-policies/delete/{id}', 'destroy')->name('insurer-policies.destroy')->can('delete-insurer-policy');
});

Route::controller(PolicyController::class)->group(function () {
    Route::get('/policies', 'index')->name('policies.index')->can('view-policies');
    Route::get('/policies/create', 'create')->name('policies.create')->can('add-policy');
    Route::post('/policies/store', 'store')->name('policies.store')->can('add-policy');
    Route::get('/policies/edit/{id}', 'edit')->name('policies.edit')->can('edit-policy');
    Route::post('/policies/edit/{id}', 'update')->name('policies.update')->can('edit-policy');
    Route::post('/policies/delete/{id}', 'destroy')->name('policies.destroy')->can('delete-policy');
    Route::get('/policies/details/{id}', 'details')->name('policies.details')->can('view-policy-details');
    Route::get('/policies/get-insurer-policies/{id}', 'getInsurerPolicy')->name('policies.getInsurerPolicy')->can('get-insurer-policies');
});

Route::prefix('/clients/{client}')->group(function () {
    Route::controller(PolicyAssignmentController::class)->group(function () {
        Route::get('/client-policies/create', 'create')->name('client-policies.create')->can('add-client-policy');
        Route::post('/client-policies/create', 'store')->name('client-policies.store')->can('add-client-policy');
    });
});

Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index')->name('invoices.index')->can('view-invoices');
    Route::get('/invoices/create', 'create')->name('invoices.create')->can('add-invoice');
    Route::post('/invoices/create', 'store')->name('invoices.store')->can('add-invoice');
    Route::get('/invoices/edit/{id}', 'edit')->name('invoices.edit')->can('edit-invoice');
    Route::post('/invoices/edit/{id}', 'update')->name('invoices.update')->can('edit-invoice');
    Route::get('/invoices/details/{id}', 'details')->name('invoices.details')->can('view-invoice-details');
    Route::get('/invoices/delete/{id}', 'destroy')->name('invoices.destroy')->can('delete-invoice');
    Route::get('/invoices/download/{id}', 'download')->name('invoices.download')->can('download-invoice');
    Route::get('/invoices/{id}/send-email', 'sendEmail')->name('invoices.sendEmail')->can('send-invoice-email');
    Route::put('/invoices/{id}/update-status', 'updateStatus')->name('invoices.updateStatus')->can('update-invoice-status');
    Route::get('/invoices/checkInvoice/{id}', 'checkInvoice')->name('invoices.checkInvoice')->can('fetch-invoice');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/payments', 'index')->name('payments.index')->can('view-payments');
    Route::get('/payments/create', 'create')->name('payments.create')->can('add-payment');
    Route::post('/payments/create', 'store')->name('payments.store')->can('add-payment');
    Route::get('/payments/edit/{id}', 'edit')->name('payments.edit')->can('edit-payment');
    Route::post('/payments/edit/{id}', 'update')->name('payments.update')->can('edit-payment');
    Route::get('/payments/details/{id}', 'details')->name('payments.details')->can('view-payment-details');
    Route::post('/payments/delete/{id}', 'destroy')->name('payments.destroy')->can('delete-payment');
    Route::get('payments/{id}/download-receipt', 'downloadReceipt')->name('payments.downloadReceipt')->can('download-payment-receipt');
    Route::post('payments/{id}/send-email', 'sendEmail')->name('payments.sendEmail')->can('send-payment-email');
    Route::patch('/payments/{id}/status', 'updateStatus')->name('payments.updateStatus')->can('update-payment-status');
});


Route::controller(SystemVariableController::class)->group(function () {
    Route::get('/system-variables', 'index')->name('system-variables.index')->can('view-system-variables');
    Route::get('/system-variables/create', 'create')->name('system-variables.create')->can('add-system-variable');
    Route::post('/system-variables/create', 'store')->name('system-variables.store')->can('add-system-variable');
    Route::get('/system-variables/edit/{id}', 'edit')->name('system-variables.edit')->can('edit-system-variable');
    Route::post('/system-variables/edit/{id}', 'update')->name('system-variables.update')->can('edit-system-variable');
    Route::get('/system-variables/details/{id}', 'details')->name('system-variables.details')->can('view-system-variable-details');
    Route::post('/system-variables/delete/{id}', 'destroy')->name('system-variables.destroy')->can('delete-system-variable');
});

Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');

Route::controller(AssignPolicyController::class)->group(function () {
    Route::get('/assign-policy', 'index')->name('assign-policy.index')->can('view-policies-assigned');
    Route::get('/assign-policy/create', 'create')->name('assign-policy.create')->can('add-policy-assignment');
    Route::post('/assign-policy/create', 'store')->name('assign-policy.store')->can('add-policy-assignment');
    Route::get('/assign-policy/edit/{id}', 'edit')->name('assign-policy.edit')->can('edit-policy-assignment');
    Route::post('/assign-policy/edit/{id}', 'update')->name('assign-policy.update')->can('edit-policy-assignment');
    Route::post('/assign-policy/delete/{id}', 'destroy')->name('assign-policy.destroy')->can('delete-policy-assignment');
    Route::get('/assign-policy/details/{id}', 'details')->name('assign-policy.details')->can('view-policy-assignment-details');
    Route::get('/assign-policy/getInsurerPolicies/{insurer_id}', 'getInsurerPolicies')->name('assign-policy.getInsurerPolicies')->can('get-insurer-policies');
    Route::get('/assign-policy/getPolicyDetails/{policy_id}', 'getPolicyDetails')->can('fetch-policy-details');
    Route::post('/assign-policy/uploadDocuments/{id}', 'uploadDocuments')->name('assign-policy.uploadDocuments')->can('upload-documents');
    Route::post('/assign-policy/setStatus/{id}', 'setPolicyStatus')->name('assign-policy.setStatus')->can('set-policy-status');
});


Route::controller(ClaimController::class)->group(function () {
    Route::get('/claims', 'index')->name('claims.index')->can('view-claims');
    Route::get('/claims/create', 'create')->name('claims.create')->can('add-claim');
    Route::post('/claims/create', 'store')->name('claims.store')->can('add-claim');
    Route::get('/claims/edit/{id}', 'edit')->name('claims.edit')->can('add-claim');
    Route::post('/claims/edit/{id}', 'update')->name('claims.update')->can('edit-claim');
    Route::post('/claims/delete/{id}', 'destroy')->name('claims.destroy')->can('delete-claim');
    Route::get('/claims/details/{id}', 'details')->name('claims.details')->can('view-claim-details');
});
