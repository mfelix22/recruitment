<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicantDocument;
use App\Models\SupportingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantDocumentController extends Controller
{
    /** Show the onboarding document upload page for a specific application */
    public function index(Application $application)
    {
        $this->authorizeApplicant($application);

        $requiredDocs = SupportingDocument::orderBy('sort_order')->orderBy('id')->get();

        // Map supporting_document_id → ApplicantDocument for easy lookup in view
        $uploaded = $application->applicantDocuments
            ->keyBy('supporting_document_id');

        return view('applicant.onboarding.index', compact('application', 'requiredDocs', 'uploaded'));
    }

    /** Upload a document for a specific supporting_document_id */
    public function store(Request $request, Application $application)
    {
        $this->authorizeApplicant($application);

        $supportingDoc = SupportingDocument::findOrFail($request->input('supporting_document_id'));

        // Build accept MIME types based on format
        $acceptedMimes = $this->getMimeForFormat($supportingDoc->format_file);

        $request->validate([
            'supporting_document_id' => ['required', 'exists:supporting_documents,id'],
            'file' => ['required', 'file', 'max:5120', 'mimes:' . $acceptedMimes],
        ], [
            'file.mimes' => 'Format file harus ' . strtoupper($supportingDoc->format_file) . '.',
            'file.max'   => 'Ukuran file maksimal 5MB.',
        ]);

        // Delete old file if exists
        $existing = $application->applicantDocuments()
            ->where('supporting_document_id', $supportingDoc->id)
            ->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->file_path);
            $existing->delete();
        }

        $path = $request->file('file')->store(
            'onboarding/' . $application->id,
            'public'
        );

        $application->applicantDocuments()->create([
            'supporting_document_id' => $supportingDoc->id,
            'file_path'              => $path,
            'original_name'          => $request->file('file')->getClientOriginalName(),
        ]);

        return back()->with('success', 'Dokumen "' . $supportingDoc->description . '" berhasil diupload.');
    }

    /** Delete an uploaded document */
    public function destroy(Application $application, ApplicantDocument $document)
    {
        $this->authorizeApplicant($application);

        if ($document->application_id !== $application->id) {
            abort(403);
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    private function authorizeApplicant(Application $application): void
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        if ($application->status !== 'Onboarding') {
            abort(403, 'Halaman ini hanya tersedia saat status lamaran adalah Onboarding.');
        }
    }

    private function getMimeForFormat(string $format): string
    {
        return match (strtolower($format)) {
            'pdf'  => 'pdf',
            'jpg'  => 'jpg,jpeg',
            'png'  => 'png',
            'doc'  => 'doc,docx',
            'docx' => 'docx,doc',
            default => $format,
        };
    }
}
