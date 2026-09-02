<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\McuMatrix;
use App\Models\McuPackage;
use App\Models\McuResult;
use App\Models\SupportingDocument;
use App\Mail\OnboardingInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class McuResultController extends Controller
{
    /** HRD: record or update MCU result for an application */
    public function update(Request $request, Application $application)
    {
        if ($application->jobPosting->employer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'mcu_package_id' => ['required', 'exists:mcu_packages,id'],
            'result'         => ['required', 'in:Lulus,Tidak Lulus'],
            'notes'          => ['nullable', 'string', 'max:1000'],
            'scheduled_date' => ['nullable', 'date'],
            'completed_date' => ['nullable', 'date'],
        ]);

        McuResult::updateOrCreate(
            ['application_id' => $application->id],
            $validated
        );

        // Auto-advance application status based on result
        $newStatus = $validated['result'] === 'Lulus' ? 'Onboarding' : 'Tidak Diterima';
        $application->update(['status' => $newStatus]);

        // Send onboarding invitation email when applicant passes MCU
        if ($newStatus === 'Onboarding') {
            try {
                Mail::to($application->applicant->email)
                    ->send(new OnboardingInvitationMail($application));
            } catch (\Exception $e) {
                // Log but don't fail — email is non-critical
                logger()->error('OnboardingInvitationMail failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Hasil MCU berhasil disimpan. Status lamaran diperbarui ke "' . $newStatus . '".');
    }

    /** Auto-assign MCU package when status moves to Menunggu MCU */
    public static function autoAssign(Application $application): void
    {
        $jobPosting = $application->jobPosting;

        // Try to find a matching matrix entry by position (case-insensitive)
        $matrix = McuMatrix::whereRaw('LOWER(employee_position) = ?', [
            strtolower($jobPosting->position ?? $jobPosting->title)
        ])->orWhereRaw('LOWER(department) = ?', [
            strtolower($jobPosting->department ?? '')
        ])->first();

        McuResult::updateOrCreate(
            ['application_id' => $application->id],
            ['mcu_package_id' => $matrix?->mcu_package_id]
        );
    }
}
