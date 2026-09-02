<?php

namespace App\Http\Controllers;

use App\Models\SupportingDocument;
use Illuminate\Http\Request;

class SupportingDocumentController extends Controller
{
    public function index()
    {
        $documents = SupportingDocument::orderBy('sort_order')->orderBy('id')->get();

        return view('hrd.dokumen.index', [
            'documents' => $documents,
            'statuses'  => SupportingDocument::STATUSES,
            'formats'   => SupportingDocument::FORMATS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'status'      => ['required', 'in:mandatory,optional'],
            'format_file' => ['required', 'in:' . implode(',', SupportingDocument::FORMATS)],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        SupportingDocument::create($validated);

        return back()->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, SupportingDocument $dokumen)
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'status'      => ['required', 'in:mandatory,optional'],
            'format_file' => ['required', 'in:' . implode(',', SupportingDocument::FORMATS)],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? $dokumen->sort_order;

        $dokumen->update($validated);

        return back()->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(SupportingDocument $dokumen)
    {
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
