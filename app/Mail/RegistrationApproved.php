<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Registration;

class RegistrationApproved extends Mailable implements ShouldQueue
{
    use Dispatchable, Queueable;
    public $registration;
    public $barcodePath;

    public function __construct(Registration $registration, $barcodePath)
    {
        $this->registration = $registration;
        $this->barcodePath = $barcodePath;
    }

    public function build()
    {
        return $this->subject('Registration Approved')
                    ->view('emails.registration-approved')
                    ->attach($this->barcodePath, [
                        'as' => 'qr_code.png',
                        'mime' => 'image/png',
                    ]);
    }
}
