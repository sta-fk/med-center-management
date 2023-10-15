<?php declare(strict_types=1);

namespace App\Catalog\Exception;

class ServiceResultNotFoundException extends \Exception
{
    protected $message = 'Service result template not found';
}
