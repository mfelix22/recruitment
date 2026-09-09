<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
{
    use Queueable;

    public function __construct(
        public Application $application,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jobTitle  = $this->application->jobPosting?->title ?? '-';
        $applicant = $this->application->applicant?->name ?? '-';

        return (new MailMessage)
            ->subject('Lamaran Baru: ' . $jobTitle)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Ada lamaran baru untuk posisi **' . $jobTitle . '**.')
            ->line('Pelamar: **' . $applicant . '**')
            ->action('Lihat Lamaran', route('employer.applications.show', $this->application));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_title'      => $this->application->jobPosting?->title,
            'applicant_name' => $this->application->applicant?->name,
            'message'        => 'Lamaran baru dari ' . ($this->application->applicant?->name ?? '-') . ' untuk "' . ($this->application->jobPosting?->title ?? '-') . '"',
            'url'            => route('employer.applications.show', $this->application),
        ];
    }
}
