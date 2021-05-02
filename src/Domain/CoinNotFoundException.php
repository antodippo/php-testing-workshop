<?php
declare(strict_types = 1);


namespace App\Domain;


class CoinNotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Coin not found';
}