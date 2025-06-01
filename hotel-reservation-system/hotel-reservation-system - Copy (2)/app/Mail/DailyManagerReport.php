<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyManagerReport extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfPath;

    public function __construct($data, $pdfPath)
    {
        $this->data = $data;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Daily Hotel Report - ' . $this->data['date'])
                    ->markdown('emails.daily_report')
                    ->attach(storage_path('app/' . $this->pdfPath));
    }
}