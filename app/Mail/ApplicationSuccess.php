<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationSuccess extends Mailable
{
    use Queueable, SerializesModels;
    protected $email, $job_title, $applicant_name;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $job_title, $applicant_name)
    {
        //
        $this->email = $email;
        $this->job_title = $job_title;
        $this->applicant_name = $applicant_name;
    }

    /**
     * Build the message.
     * 
     * @return $this
     */
     public function build()
     {
        $email = $this->email;
        $job_title = $this->job_title;
        $applicant_name = $this->applicant_name;
        // dd('123');
        // $url = config('app.fronturl').'/application/success';
        // \Log::info($template);
        return $this->from('tosinpeter15@gmail.com', config('app.name'))
            ->subject('Application Successful')
            ->view('mails.application-success')
            ->with([
            'email' => $email,
            'job_title' => $job_title,
            'applicant_name' => $applicant_name,
            // 'url' => $url,
        ]);
     }
    /**
     * Get the message content definition.
     */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
}
