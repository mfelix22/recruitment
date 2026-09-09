<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        public int $employerId,
        public ?int $jobPostingId = null,
        public ?string $status = null,
    ) {}

    public function collection(): Collection
    {
        $query = Application::whereHas('jobPosting', function ($q) {
            $q->where('employer_id', $this->employerId);
        })->with(['applicant.applicantProfile', 'jobPosting'])->latest();

        if ($this->jobPostingId) {
            $query->where('job_posting_id', $this->jobPostingId);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pelamar',
            'Email',
            'No. HP',
            'Lowongan',
            'Posisi',
            'Status',
            'Tanggal Melamar',
            'Jadwal Interview',
        ];
    }

    public function map($application): array
    {
        return [
            $application->applicant?->name,
            $application->applicant?->email,
            $application->applicant?->applicantProfile?->phone ?? '-',
            $application->jobPosting?->title,
            $application->jobPosting?->position,
            $application->status,
            $application->created_at?->format('d/m/Y H:i'),
            $application->interview_at?->format('d/m/Y H:i') ?? '-',
        ];
    }
}
