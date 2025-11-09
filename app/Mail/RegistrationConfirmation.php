<?php

namespace App\Mail;

use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $defaultImagePath;
    public $qrCodeImagePath;
    /**
     * Create a new message instance.
     *
     * @param $registration
     */
    public function __construct($registration)
    {
        $this->registration = $registration;
        $this->defaultImagePath = public_path('default-image/qr-code.jpg');
        $this->qrCodeImagePath = public_path($registration->qr_code_path);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registration Confirmation and Your QR Code')
        ->view('frontend.emails.registration_confirmation')
        ->with([
            'registration' => $this->registration,
            'defaultImagePath' => $this->defaultImagePath,
            'qrCodeImagePath' => $this->qrCodeImagePath,
        ]);
    }
}
