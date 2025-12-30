<?php

namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;

class AfricasTalkingService
{
    protected $sms;

    public function __construct()
    {
        $username = config('petrolsystem');
        $apiKey   = config('atsk_23af29a355c773b10a9754dbcc4302428596125309321c13f9ebeed3769c4f7c63b8f72d');

        if (!$username || !$apiKey) {
            throw new \Exception('Africa\'s Talking credentials are missing.');
        }

        $AT = new AfricasTalking($username, $apiKey);
        $this->sms = $AT->sms();
    }

    public function send($to, $message)
    {
        return $this->sms->send([
            'to'      => $to,
            'message' => $message,
        ]);
    }
}
