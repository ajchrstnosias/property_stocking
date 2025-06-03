<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\ItemRequestController as AdminItemRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\ItemRequestController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Item Request Routes (for Staff)
    Route::get('/requests/create', [ItemRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ItemRequestController::class, 'store'])->name('requests.store');
    Route::patch('/requests/{itemRequest}/initiate-return', [ItemRequestController::class, 'initiateReturn'])->name('requests.initiateReturn');
    Route::get('/my-requests', [ItemRequestController::class, 'myRequestsIndex'])->name('requests.myIndex');
    Route::get('/my-transactions/report/pdf', [ItemRequestController::class, 'downloadMyTransactionsReport'])->name('requests.myTransactionsReportPdf');
    // We might add index, show, edit, update for requests later if staff need to manage their requests further
});

// Admin Routes
Route::middleware(['auth', 'verified', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminItemRequestController::class, 'index'])->name('dashboard');

    Route::resource('items', AdminItemController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('locations', AdminLocationController::class);

    // Item Requests Management for Admin
    Route::get('/requests', [AdminItemRequestController::class, 'index'])->name('requests.index');
    Route::patch('/requests/{itemRequest}/approve', [AdminItemRequestController::class, 'approve'])->name('requests.approve');
    Route::patch('/requests/{itemRequest}/deny', [AdminItemRequestController::class, 'deny'])->name('requests.deny');
    Route::patch('/requests/{itemRequest}/approve-return', [AdminItemRequestController::class, 'approveReturn'])->name('requests.approveReturn');
    Route::patch('/requests/{itemRequest}/deny-return', [AdminItemRequestController::class, 'denyReturn'])->name('requests.denyReturn');
    // Potentially a show route for more details: Route::get('/requests/{itemRequest}', [AdminItemRequestController::class, 'show'])->name('requests.show');

    // Admin Reports Routes
    Route::get('/reports/transactions', [AdminReportController::class, 'transactionsReportForm'])->name('reports.transactions.form');
    Route::get('/reports/transactions/pdf', [AdminReportController::class, 'downloadTransactionsReport'])->name('reports.transactions.pdf');

    // Add other admin routes here (e.g., for managing users, item requests, stock movements)
});

require __DIR__.'/auth.php';
