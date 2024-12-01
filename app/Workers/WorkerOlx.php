<?php

namespace App\Workers;

use App\Helpers\Parser\PriceOlx;
use App\Mail\PriceEmail;
use App\Models\Price;
use Illuminate\Support\Facades\Mail;

class WorkerOlx extends WorkerAbstract
{
    /**
     * Olx worker invoke.
     */
    public function __invoke()
    {
        $this->price();
    }

    /**
     * Check prices. If changed, update in DB and send email.
     * 
     * @return void
     */
    private function price()
    {
        $adverts = Price::olx()->get();
        (new PriceOlx($adverts))->refresh();

        foreach ($adverts as $advert) {
            // Update price
            Price::find($advert->id)->update([
                'amount' => $advert->amount
            ]);
            // Send email
            $recipients = $advert->users
                ->pluck('email')
                ->toArray();
            $email = new PriceEmail($advert);
            Mail::to($recipients)->send($email);
        }
    }
}
