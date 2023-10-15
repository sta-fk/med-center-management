<?php declare(strict_types=1);

namespace App\Appointments\Twig;

use libphonenumber\PhoneNumber;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppointmentsExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_phone_number', [$this, 'formatPhoneNumber'], array('is_safe' => array('html'))),
            new TwigFunction('format_service_duration', [$this, 'formatServiceDuration'], array('is_safe' => array('html'))),
        ];
    }

    public function formatPhoneNumber(PhoneNumber $phoneNumber): string
    {
        return $phoneNumber->getCountryCode() . $phoneNumber->getNationalNumber();
    }

    public function formatServiceDuration(\DateTimeImmutable $time): string
    {
        $time = $time->format('H:i');
        $timeSplit = explode(':', $time);
        $timeResult = '';

        if ($timeSplit[0] !== '00') {
            $timeResult .= (int)$timeSplit[0] . 'год. ';
        }

        if ($timeSplit[1] !== '00') {
            $timeResult .= (int)$timeSplit[1] . 'хв.';
        }

        return $timeResult;
    }
}
