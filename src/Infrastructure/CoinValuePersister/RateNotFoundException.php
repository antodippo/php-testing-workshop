<?php


namespace App\Infrastructure\CoinValuePersister;


class RateNotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Rate not found';
}