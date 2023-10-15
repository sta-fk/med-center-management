<?php declare(strict_types=1);

namespace App\Division\Exception;

class NotAvailableDivisionType extends \Exception
{
    protected $message = 'Division type not available';
}
