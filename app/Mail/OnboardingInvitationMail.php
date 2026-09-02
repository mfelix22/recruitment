<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\SupportingDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnboardingInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $requiredDocs;

    public function __construct(public Application $application)
    {
        $this->requiredDocs = SupportingDocument::orderBy('sort_order')->get()->all();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Anda Diterima - Lengkapi Dokumen Onboarding',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.onboarding-invitation',
        );
    }
}
