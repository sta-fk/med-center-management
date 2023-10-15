<?php declare(strict_types=1);

namespace App\PatientUser\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PatientServiceResultExtension extends AbstractExtension
{
    public function __construct(
        private Environment $twig,
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_child', [$this, 'renderChild'], array('is_safe' => array('html'))),
            new TwigFunction('calculate_age', [$this, 'calculateAge'], array('is_safe' => array('html'))),
            new TwigFunction('format_unit', [$this, 'formatUnit'], array('is_safe' => array('html'))),
        ];
    }

    public function getFilters(): array
    {
        return [
//            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function calculateAge(string $date): float
    {
        $today = new \DateTimeImmutable('now');
        $birthday = new \DateTimeImmutable($date);
        $todayD = ((int)$today->format('Y') * 12 + (int)$today->format('m')) * 31 + (int)$today->format('d') - 1;
        $birthdayD = ((int)$birthday->format('Y') * 12 + (int)$birthday->format('m')) * 31 + (int)$birthday->format('d') - 1;

        return floor(abs($todayD - $birthdayD) / 31 / 12);
    }

    public function formatUnit(string $unit): string
    {
        if (preg_match('/^\d+\^\d+\/.*$/', $unit)) {
            $numbers = explode('^', $unit);
            $symbols = explode('/', $numbers[1]);
            return sprintf(
                '%s<sup>%s</sup>/%s',
                $numbers[0],
                $symbols[0],
                $symbols[1],
            );
        }

        return $unit;
    }

    public function renderChild(array $child): string
    {
        return $this->twig->render('child.html.twig', ['raw' => $child]);
    }
}
