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
    public $emailView; 

    public function __construct(Registration $registration, $barcodePath, $emailView)
    {
        $this->registration = $registration;
        $this->barcodePath = $barcodePath;
        $this->emailView = $emailView;  
    }

    public function build()
    {
        return $this->subject('Registration Approved')
                    ->view($this->emailView)
                    ->with([
                        'certificatePath' => $this->barcodePath,
                        'registration' => $this->registration,
                    ])
                    ->attach($this->barcodePath, [
                        'as' => 'qr_code.png',
                        'mime' => 'image/png',
                    ]);
    }
    
}
