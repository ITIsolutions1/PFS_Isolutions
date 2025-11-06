<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExperienceDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\CustomerPersonaController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RfpController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\ProposalController;

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

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');




// Route::get('/dashboard', function () {
//     return redirect()->route('experiences.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('experience', [ExperienceDetailController::class, 'index'])->name('experience.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('experiences', ExperienceDetailController::class);
    Route::get('/experiences/{experiences}/pdffs', [ExperienceDetailController::class, 'generatePDFFS'])->name('experiences.pdffs');
    Route::get('/experiences/{experiences}/bast', [ExperienceDetailController::class, 'generateBAST'])->name('experiences.bast');
    Route::get('export', [ExperienceDetailController::class, 'export'])->name('experiences.export');
    Route::post('/import', [ExperienceDetailController::class, 'import'])->name('experiences.import');

    Route::get('/experiences/pdf/all', [ExperienceDetailController::class, 'generatePdfAll'])->name('experiences.pdfAll');
    // routes/web.php
    Route::get('/projects/year/{year}', [DashboardController::class, 'getProjectsByYear']);
    Route::get('/projects/status/{status}', [DashboardController::class, 'getProjectsByStatus']);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // CRM ROUTES
    Route::get('admin/crm', [CrmController::class, 'index'])->name('crm.index');
    Route::get('admin/crm/create', [CrmController::class, 'create'])->name('crm.create');
    Route::post('admin/crm/store', [CrmController::class, 'store'])->name('crm.store');
    Route::get('admin/crm/{id}/edit', [CrmController::class, 'edit'])->name('crm.edit');
    Route::put('admin/crm/{id}', [CrmController::class, 'update'])->name('crm.update');
    Route::delete('admin/crm/{id}', [CrmController::class, 'destroy'])->name('crm.destroy');
    Route::get('admin/crm/{id}', [CrmController::class, 'show'])->name('crm.show');
     Route::put('/admin/crm/{id}/update-multiple', [CrmController::class, 'updateMultiple'])->name('crm.updateMultiple');

    // Untuk update field CRM
    Route::put('/crm/{crm}/{field}', [CrmController::class, 'updateField'])->name('crm.updateField');
    // Untuk update field persona
    Route::put('/persona/{persona}/{field}', [CustomerPersonaController::class, 'updateField'])->name('persona.updateField');



    //C=USTOMER PERSONA ROUTES
    Route::resource('personas', CustomerPersonaController::class);
    Route::put('/persona/{id}/update-multiple', [PersonaController::class, 'updateMultiple']);



    // LEADS ROUTES

   route::resource('leads', LeadController::class);
   route::get('/leads-dashboard', [LeadController::class, 'dashboard'])->name('leads.dashboard');
   // Menampilkan leads berdasarkan kategori
    Route::get('/leads/category/{category}', [LeadController::class, 'byCategory'])->name('leads.byCategory');

    Route::prefix('admin/leads/{lead_id}/followups')->group(function () {
    Route::get('/', [FollowUpController::class, 'index'])->name('followups.index');
    Route::post('/', [FollowUpController::class, 'store'])->name('followups.store');
    Route::post('/appointments', [FollowUpController::class, 'appointments_store'])->name('appointments.store');
    Route::get('{id}/edit', [FollowUpController::class, 'edit'])->name('followups.edit');
    Route::put('{id}', [FollowUpController::class, 'update'])->name('followups.update');
    Route::delete('{id}', [FollowUpController::class, 'destroy'])->name('followups.destroy');
    });



    Route::post('crms/add-lead/{crm}', [LeadController::class, 'createFromCrm'])->name('leads.createFromCrm');
    Route::get('/leads/status/{status}', [LeadController::class, 'leadByStatus'])->name('leads.byStatus');
    Route::get('admin/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');

    Route::resource('categories', CategoryController::class);


    // Broadcast Email Routes
    Route::get('/broadcastMail', [BroadcastController::class, 'create'])->name('broadcast.create');
    Route::post('/broadcastMail', [BroadcastController::class, 'send'])->name('broadcast.send');
    Route::get('/broadcast', [BroadcastController::class, 'index'])->name('broadcast.index');
    Route::get('broadcast/{broadcast}/edit', [BroadcastController::class, 'edit'])->name('broadcast.edit');
    Route::put('broadcast/{broadcast}', [BroadcastController::class, 'update'])->name('broadcast.update');
    Route::delete('broadcast/{broadcast}', [BroadcastController::class, 'destroy'])->name('broadcast.destroy');


    //proposal routes
    Route::resource('proposals', ProposalController::class);
    Route::get('proposals/show/{id}', [ProposalController::class, 'show2'])->name('proposals.show2');

    // Route::get('experience/create/{rfp_id}', [ExperienceDetailController::class, 'createFromRfp'])->name('experience.createFromRfp');
    // Route::post('experience/store', [ExperienceDetailController::class, 'storeRfp'])->name('experience.storeRfp');
    //  Route::get('rfp/create/{lead_id}', [RfpController::class, 'create'])->name('rfp.createFromLead');
    // Route::resource('rfp', RfpController::class);

});


// Semua user yang login bisa akses leads
Route::middleware(['auth'])->group(function () {
     route::resource('leads', LeadController::class);
   route::get('/leads-dashboard', [LeadController::class, 'dashboard'])->name('leads.dashboard');
   // Menampilkan leads berdasarkan kategori
    Route::get('/leads/category/{category}', [LeadController::class, 'byCategory'])->name('leads.byCategory');

    Route::prefix('admin/leads/{lead_id}/followups')->group(function () {
    Route::get('/', [FollowUpController::class, 'index'])->name('followups.index');
    Route::post('/', [FollowUpController::class, 'store'])->name('followups.store');
    Route::get('{id}/edit', [FollowUpController::class, 'edit'])->name('followups.edit');
    Route::put('{id}', [FollowUpController::class, 'update'])->name('followups.update');
    Route::delete('{id}', [FollowUpController::class, 'destroy'])->name('followups.destroy');

    });

      Route::get('admin/crm', [CrmController::class, 'index'])->name('crm.index');
    Route::get('admin/crm/create', [CrmController::class, 'create'])->name('crm.create');
    Route::post('admin/crm/store', [CrmController::class, 'store'])->name('crm.store');
    Route::get('admin/crm/{id}/edit', [CrmController::class, 'edit'])->name('crm.edit');
    Route::put('admin/crm/{id}', [CrmController::class, 'update'])->name('crm.update');
    Route::delete('admin/crm/{id}', [CrmController::class, 'destroy'])->name('crm.destroy');
    Route::get('admin/crm/{id}', [CrmController::class, 'show'])->name('crm.show');
     Route::put('/admin/crm/{id}/update-multiple', [CrmController::class, 'updateMultiple'])->name('crm.updateMultiple');

    // Untuk update field CRM
    Route::put('/crm/{crm}/{field}', [CrmController::class, 'updateField'])->name('crm.updateField');
    // Untuk update field persona
    Route::put('/persona/{persona}/{field}', [CustomerPersonaController::class, 'updateField'])->name('persona.updateField');



    //C=USTOMER PERSONA ROUTES
    Route::resource('personas', CustomerPersonaController::class);
    Route::put('/persona/{id}/update-multiple', [PersonaController::class, 'updateMultiple']);





});


});

Route::get('/form-crm', [CRMController::class, 'formCrm'])->name('crm.formCrm');
Route::post('/form-crm', [CRMController::class, 'submitForm'])->name('crm.submitForm');



require __DIR__.'/auth.php';
