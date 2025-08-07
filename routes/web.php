<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoxMatrixController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\HospitalController;

Route::get('/', function () {
    return view('home');
});

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
});
