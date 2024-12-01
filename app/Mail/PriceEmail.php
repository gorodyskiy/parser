<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
  
class PriceEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * 
     * @param Collection $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build email template.
     * 
     * @return self
     */
    public function build()
    {
        return $this->subject('RPrice has been changed')
            ->view('mail.price', [
                'link' => $this->data->link,
                'amount' => $this->data->amount,
                'currency' => $this->data->currency,
            ]);
    }

    /**
     * Get the message envelope.
     * 
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Price has been changed',
        );
    }

    /**
     * Get the message content definition.
     * 
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.price',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array

     */
    public function attachments(): array
    {
        return [];
    }
}