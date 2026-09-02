<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\McuItemController;
use App\Http\Controllers\McuMatrixController;
use App\Http\Controllers\McuResultController;
use App\Http\Controllers\SupportingDocumentController;
use App\Http\Controllers\ApplicantDocumentController;
use App\Http\Controllers\QuickProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jobs = \App\Models\JobPosting::active()->latest()->take(6)->get();
    return view('welcome', compact('jobs'));
});

Route::get('/dashboard', function () {
    if (auth()->user()->isEmployer()) {
        return redirect()->route('employer.dashboard');
    }
    // Send applicant to setup if Phase 1 not done
    $profile = auth()->user()->applicantProfile;
    if (! $profile || ! $profile->isBasicComplete()) {
        return redirect()->route('applicant.setup');
    }
    return redirect()->route('applicant.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Breeze account profile (email, password)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Applicant routes ────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:applicant'])->prefix('pelamar')->name('applicant.')->group(function () {
    // ── Phase 1: Setup (no basic.complete guard — this IS the setup page) ──
    Route::get('/lengkapi-profil', [QuickProfileController::class, 'show'])->name('setup');
    Route::post('/lengkapi-profil', [QuickProfileController::class, 'store'])->name('setup.store');

    // Pendidikan (accessible before profile is basic complete)
    Route::get('/pendidikan', [EducationController::class, 'index'])->name('education.index');
    Route::get('/pendidikan/tambah', [EducationController::class, 'create'])->name('education.create');
    Route::post('/pendidikan', [EducationController::class, 'store'])->name('education.store');
    Route::get('/pendidikan/{education}/ubah', [EducationController::class, 'edit'])->name('education.edit');
    Route::put('/pendidikan/{education}', [EducationController::class, 'update'])->name('education.update');
    Route::delete('/pendidikan/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

    // Pengalaman kerja (accessible before profile is basic complete)
    Route::get('/pengalaman-kerja', [WorkExperienceController::class, 'index'])->name('work.index');
    Route::get('/pengalaman-kerja/tambah', [WorkExperienceController::class, 'create'])->name('work.create');
    Route::post('/pengalaman-kerja', [WorkExperienceController::class, 'store'])->name('work.store');
    Route::get('/pengalaman-kerja/{workExperience}/ubah', [WorkExperienceController::class, 'edit'])->name('work.edit');
    Route::put('/pengalaman-kerja/{workExperience}', [WorkExperienceController::class, 'update'])->name('work.update');
    Route::delete('/pengalaman-kerja/{workExperience}', [WorkExperienceController::class, 'destroy'])->name('work.destroy');

    // Data diri is always accessible (it IS the form that completes basic profile)
    Route::get('/data-diri', [ApplicantProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/data-diri', [ApplicantProfileController::class, 'update'])->name('profile.update');

    // ── All other pages require Phase 1 to be complete ──────────────────────
    Route::middleware('basic.complete')->group(function () {
        Route::get('/beranda', fn() => view('applicant.dashboard'))->name('dashboard');

        // Lowongan (browsing is always allowed after Phase 1)
        Route::get('/lowongan', [JobPostingController::class, 'index'])->name('jobs.index');
        Route::get('/lowongan/{jobPosting}', [JobPostingController::class, 'show'])->name('jobs.show');

        Route::post('/lowongan/{jobPosting}/lamar', [ApplicationController::class, 'store'])->name('apply');

        Route::get('/lamaran-saya', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/lamaran-saya/{application}', [ApplicationController::class, 'show'])->name('applications.show');

        // Onboarding document upload
        Route::get('/lamaran-saya/{application}/onboarding', [ApplicantDocumentController::class, 'index'])->name('onboarding.index');
        Route::post('/lamaran-saya/{application}/onboarding', [ApplicantDocumentController::class, 'store'])->name('onboarding.store');
        Route::delete('/lamaran-saya/{application}/onboarding/{document}', [ApplicantDocumentController::class, 'destroy'])->name('onboarding.destroy');
    }); // end basic.complete
});

// ─── Employer / HRD routes ───────────────────────────────────────────────────
Route::middleware(['auth', 'role:employer'])->prefix('hrd')->name('employer.')->group(function () {

    Route::get('/beranda', fn() => view('hrd.dashboard'))->name('dashboard');

    // Kelola lowongan
    Route::get('/lowongan', [JobPostingController::class, 'employerIndex'])->name('lowongan.index');
    Route::get('/lowongan/tambah', [JobPostingController::class, 'create'])->name('lowongan.create');
    Route::post('/lowongan', [JobPostingController::class, 'store'])->name('lowongan.store');
    Route::get('/lowongan/{lowongan}/ubah', [JobPostingController::class, 'edit'])->name('lowongan.edit');
    Route::put('/lowongan/{lowongan}', [JobPostingController::class, 'update'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}', [JobPostingController::class, 'destroy'])->name('lowongan.destroy');

    // Lihat & kelola lamaran masuk
    Route::get('/lamaran', [ApplicationController::class, 'employerIndex'])->name('applications.index');
    Route::get('/lamaran/kanban', [ApplicationController::class, 'kanban'])->name('applications.kanban');
    Route::get('/lamaran/{application}', [ApplicationController::class, 'employerShow'])->name('applications.show');
    Route::get('/lamaran/{application}/pdf', [ApplicationController::class, 'downloadPdf'])->name('applications.pdf');
    Route::patch('/lamaran/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
    Route::patch('/lamaran/{application}/status-ajax', [ApplicationController::class, 'updateStatusAjax'])->name('applications.status.ajax');
    Route::patch('/lamaran/{application}/mcu', [McuResultController::class, 'update'])->name('applications.mcu');

    // Kelola paket MCU & item
    Route::get('/mcu/paket', [McuItemController::class, 'index'])->name('mcu.paket.index');
    Route::post('/mcu/paket', [McuItemController::class, 'store'])->name('mcu.paket.store');
    Route::put('/mcu/paket/{mcuItem}', [McuItemController::class, 'update'])->name('mcu.paket.update');
    Route::delete('/mcu/paket/{mcuItem}', [McuItemController::class, 'destroy'])->name('mcu.paket.destroy');

    // Matrix MCU
    Route::get('/mcu/matrix', [McuMatrixController::class, 'index'])->name('mcu.matrix.index');
    Route::post('/mcu/matrix', [McuMatrixController::class, 'store'])->name('mcu.matrix.store');
    Route::put('/mcu/matrix/{mcuMatrix}', [McuMatrixController::class, 'update'])->name('mcu.matrix.update');
    Route::delete('/mcu/matrix/{mcuMatrix}', [McuMatrixController::class, 'destroy'])->name('mcu.matrix.destroy');

    // Supporting documents (Onboarding)
    Route::get('/dokumen', [SupportingDocumentController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen', [SupportingDocumentController::class, 'store'])->name('dokumen.store');
    Route::put('/dokumen/{dokumen}', [SupportingDocumentController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{dokumen}', [SupportingDocumentController::class, 'destroy'])->name('dokumen.destroy');
});

require __DIR__ . '/auth.php';
