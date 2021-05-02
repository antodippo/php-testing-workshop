<?php


namespace App\Domain;


class InvalidCurrencyException extends \Exception
{
    protected $code = 400;
    protected $message = 'Invalid currency';
}