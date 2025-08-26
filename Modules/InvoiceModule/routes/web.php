<?php

use Illuminate\Support\Facades\Route;
use Modules\InvoiceModule\app\Http\Controllers\Admin\InvoiceAdminController;
use Modules\InvoiceModule\app\Http\Controllers\InvoiceModuleController;

Route::group(['prefix' => 'invoices', 'middleware' => ['auth:admin']], function () {


    Route::get('/', [InvoiceAdminController::class, 'index'])->name('invoices');
    Route::get('/add', [InvoiceAdminController::class, 'create'])->name('invoices.add');
    Route::post('/store', [InvoiceAdminController::class, 'store'])->name('invoices.store');
    Route::get('/view/{id}', [InvoiceAdminController::class, 'show'])->name('invoices.view');
    Route::get('/edit/{id}', [InvoiceAdminController::class, 'edit'])->name('invoices.edit');
    Route::post('/update', [InvoiceAdminController::class, 'update'])->name('invoices.update');
    Route::post('/delete/{id}', [InvoiceAdminController::class, 'destroy'])->name('invoices.delete');
    Route::get('changeInvoiceActivity/{id}', [InvoiceAdminController::class, 'changeInvoiceActivity'])->name('invoices.change_activity');
});
