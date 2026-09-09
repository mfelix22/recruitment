<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    /**
     * Statuses that already send a dedicated mailable from
     * ApplicationController — skip the generic mail to avoid duplicates.
     */
    private const STATUSES_WITH_DEDICATED_MAIL = [
        'Dipanggil Interview',
        'Menunggu MCU',
        'Onboarding',
    ];

    public function __construct(
        public Application $application,
        public string $status,
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (! in_array($this->status, self::STATUSES_WITH_DEDICATED_MAIL, true)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jobTitle = $this->application->jobPosting?->title ?? '-';

        return (new MailMessage)
            ->subject('Update Status Lamaran: ' . $jobTitle)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Status lamaran Anda untuk posisi **' . $jobTitle . '** telah diperbarui menjadi: **' . $this->status . '**.')
            ->action('Lihat Detail Lamaran', route('applicant.applications.show', $this->application))
            ->line('Terima kasih telah melamar.');
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
