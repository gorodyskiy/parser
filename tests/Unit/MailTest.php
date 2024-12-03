<?php

namespace Tests\Unit;

use App\Mail\PriceEmail;
use App\Models\Price;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    /**
     * @var Collection
     */
    protected $data;

    /**
     * Setting up test.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->data = Price::firstOrNew([
            'link' => 'https://olx.ua/',
            'type' => 'olx',
            'amount' => 99.99,
            'currency' => 'UAH',
        ]);
    }

    /**
     * Mail sending test.
     *
     * @return void
     */
    public function testSending(): void
    {
        $mail = Mail::fake();
        $mail->assertNotSent(PriceEmail::class);
        $mail->send(new PriceEmail($this->data));
        $mail->assertSent(PriceEmail::class);
    }

    /**
     * Mail details test.
     * 
     * @return void
     */
    public function testDetails(): void
    {
        $mail = new PriceEmail($this->data);
        $mail->assertFrom('noreply@parser.local');
        $mail->assertHasSubject('Price has been changed');
    }
}
