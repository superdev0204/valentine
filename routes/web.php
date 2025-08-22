<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BoxMatrixController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\SchoolReportController;
use App\Http\Controllers\Admin\HospitalReportController;
use App\Http\Controllers\Admin\VolunteerController;

Route::get('/', function () {
    return view('home');
});

Route::get('/register/school', [App\Http\Controllers\SchoolController::class, 'create'])->name('school.register');
Route::post('/register/school', [App\Http\Controllers\SchoolController::class, 'store'])->name('school.register.store');
Route::get('/school/{school}/edit', [App\Http\Controllers\SchoolController::class, 'edit'])->name('school.edit');
Route::put('/school/{school}', [App\Http\Controllers\SchoolController::class, 'update'])->name('school.update');

Route::get('/register/hospital', [App\Http\Controllers\HospitalController::class, 'create'])->name('hospital.register');
Route::post('/register/hospital', [App\Http\Controllers\HospitalController::class, 'store'])->name('hospital.register.store');
Route::get('/hospital/{hospital}/edit', [App\Http\Controllers\HospitalController::class, 'edit'])->name('hospital.edit');
Route::put('/hospital/{hospital}', [App\Http\Controllers\HospitalController::class, 'update'])->name('hospital.update');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'userList'])->name('admin.users');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    // School Box Size Matrix routes
    Route::get('/admin/school-box-matrices', [BoxMatrixController::class, 'schoolBoxMatrixList'])->name('admin.school-box-matrices');
    Route::get('/admin/school-box-matrices/create', [BoxMatrixController::class, 'createSchoolBoxMatrix'])->name('admin.school-box-matrices.create');
    Route::post('/admin/school-box-matrices', [BoxMatrixController::class, 'storeSchoolBoxMatrix'])->name('admin.school-box-matrices.store');
    Route::get('/admin/school-box-matrices/{boxMatrix}/edit', [BoxMatrixController::class, 'editSchoolBoxMatrix'])->name('admin.school-box-matrices.edit');
    Route::put('/admin/school-box-matrices/{boxMatrix}', [BoxMatrixController::class, 'updateSchoolBoxMatrix'])->name('admin.school-box-matrices.update');
    Route::delete('/admin/school-box-matrices/{boxMatrix}', [BoxMatrixController::class, 'deleteSchoolBoxMatrix'])->name('admin.school-box-matrices.delete');

    // Hospital Box Size Matrix routes
    Route::get('/admin/hospital-box-matrices', [BoxMatrixController::class, 'hospitalBoxMatrixList'])->name('admin.hospital-box-matrices');
    Route::get('/admin/hospital-box-matrices/create', [BoxMatrixController::class, 'createHospitalBoxMatrix'])->name('admin.hospital-box-matrices.create');
    Route::post('/admin/hospital-box-matrices', [BoxMatrixController::class, 'storeHospitalBoxMatrix'])->name('admin.hospital-box-matrices.store');
    Route::get('/admin/hospital-box-matrices/{boxMatrix}/edit', [BoxMatrixController::class, 'editHospitalBoxMatrix'])->name('admin.hospital-box-matrices.edit');
    Route::put('/admin/hospital-box-matrices/{boxMatrix}', [BoxMatrixController::class, 'updateHospitalBoxMatrix'])->name('admin.hospital-box-matrices.update');
    Route::delete('/admin/hospital-box-matrices/{boxMatrix}', [BoxMatrixController::class, 'deleteHospitalBoxMatrix'])->name('admin.hospital-box-matrices.delete');
    
    // Schools routes
    Route::get('/admin/schools', [SchoolController::class, 'schoolList'])->name('admin.schools');
    Route::get('/admin/schools/create', [SchoolController::class, 'createSchool'])->name('admin.schools.create');
    Route::post('/admin/schools', [SchoolController::class, 'storeSchool'])->name('admin.schools.store');
    Route::get('/admin/schools/{school}/edit', [SchoolController::class, 'editSchool'])->name('admin.schools.edit');
    Route::put('/admin/schools/{school}', [SchoolController::class, 'updateSchool'])->name('admin.schools.update');
    Route::delete('/admin/schools/{school}', [SchoolController::class, 'deleteSchool'])->name('admin.schools.delete');
    Route::post('/admin/schools/import', [SchoolController::class, 'importSchools'])->name('admin.schools.import');
    
    // Hospitals routes
    Route::get('/admin/hospitals', [HospitalController::class, 'hospitalList'])->name('admin.hospitals');
    Route::get('/admin/hospitals/create', [HospitalController::class, 'createHospital'])->name('admin.hospitals.create');
    Route::post('/admin/hospitals', [HospitalController::class, 'storeHospital'])->name('admin.hospitals.store');
    Route::get('/admin/hospitals/{hospital}/edit', [HospitalController::class, 'editHospital'])->name('admin.hospitals.edit');
    Route::put('/admin/hospitals/{hospital}', [HospitalController::class, 'updateHospital'])->name('admin.hospitals.update');
    Route::delete('/admin/hospitals/{hospital}', [HospitalController::class, 'deleteHospital'])->name('admin.hospitals.delete');
    Route::post('/admin/hospitals/import', [HospitalController::class, 'importHospitals'])->name('admin.hospitals.import');


    // Export routes
    Route::get('/admin/schools/sendgrid/export', [SchoolController::class, 'exportSendgridCsv'])->name('admin.schools.sendgrid.export');
    Route::get('/admin/schools/fedex/export', [SchoolController::class, 'exportFedexCsv'])->name('admin.schools.fedex.export');
    Route::get('/admin/hospitals/sendgrid/export', [HospitalController::class, 'exportSendgridCsv'])->name('admin.hospitals.sendgrid.export');
    Route::get('/admin/hospitals/fedex/export', [HospitalController::class, 'exportFedexCsv'])->name('admin.hospitals.fedex.export');

    Route::prefix('admin/schools')->name('admin.schools.')->group(function () {
        Route::get('reports', [SchoolReportController::class, 'index'])
            ->name('reports'); // page (or modal content)
        Route::get('reports/data', [SchoolReportController::class, 'data'])
            ->name('reports.data'); // JSON for DataTables
        Route::get('reports/export/{type}', [SchoolReportController::class, 'export'])
            ->whereIn('type', ['csv','xlsx','pdf'])
            ->name('reports.export');
        Route::post('reports/export/sheets', [SchoolReportController::class, 'exportToSheets'])
            ->name('reports.export.sheets'); // optional Google Sheets
    });

    Route::prefix('admin/hospitals')->name('admin.hospitals.')->group(function () {
        Route::get('reports', [HospitalReportController::class, 'index'])
            ->name('reports'); // page (or modal content)
        Route::get('reports/data', [HospitalReportController::class, 'data'])
            ->name('reports.data'); // JSON for DataTables
        Route::get('reports/export/{type}', [HospitalReportController::class, 'export'])
            ->whereIn('type', ['csv','xlsx','pdf'])
            ->name('reports.export');
        Route::post('reports/export/sheets', [HospitalReportController::class, 'exportToSheets'])
            ->name('reports.export.sheets'); // optional Google Sheets
    });

    // Volunteers routes
    Route::get('/admin/volunteers', [VolunteerController::class, 'volunteerList'])->name('admin.volunteers');
    Route::get('/admin/volunteers/create', [VolunteerController::class, 'create'])->name('admin.volunteers.create');
    Route::post('/admin/volunteers', [VolunteerController::class, 'store'])->name('admin.volunteers.store');
    Route::get('/admin/volunteers/{volunteer}/edit', [VolunteerController::class, 'edit'])->name('admin.volunteers.edit');
    Route::put('/admin/volunteers/{volunteer}', [VolunteerController::class, 'update'])->name('admin.volunteers.update');
    Route::delete('/admin/volunteers/{volunteer}', [VolunteerController::class, 'delete'])->name('admin.volunteers.delete');
    
});
