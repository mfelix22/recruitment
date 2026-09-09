<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public Application $application,
        public string $status,
    ) {}

    public function via(object $notifiable): array
    {
        // Database only; keep dedicated mailables for Interview and Onboarding.
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_title'      => $this->application->jobPosting?->title,
            'status'         => $this->status,
            'message'        => 'Status lamaran "' . ($this->application->jobPosting?->title ?? '-') . '" berubah menjadi: ' . $this->status,
            'url'            => route('applicant.applications.show', $this->application),
        ];
    }
}
