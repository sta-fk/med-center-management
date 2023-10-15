<?php declare(strict_types=1);

namespace App\Division\Enum;

use App\Division\Exception\NotAvailableDivisionType;

class DivisionType
{
    const CLINIC_SLUG = 'CLINIC';
    const LABORATORY_SLUG = 'LABORATORY';

    const TYPES = [
        self::CLINIC_SLUG => 'Клініка',
        self::LABORATORY_SLUG => 'Лабораторія',
    ];

    /**
     * @throws NotAvailableDivisionType
     */
    public static function getEnumValueBySlug(string $slug): string
    {
        $result = array_filter(
            array_map(
            function ($key, $value) use ($slug) {
                return $slug === $key ? $value : null;
            }, array_keys(self::TYPES), self::TYPES
            ));

        return $result[0] ?? throw new NotAvailableDivisionType('Division type '. $slug. ' not available');
    }
}
