<?php declare(strict_types=1);

namespace App\Catalog\Enum;

use JetBrains\PhpStorm\ArrayShape;

class PriceListContent
{
    const SERVICE = 'Послуги';
    const SERVICE_SLUG = 'services';
    const RESEARCH = 'Дослідження';
    const RESEARCH_SLUG = 'researches';

    #[ArrayShape([self::SERVICE_SLUG => "string", self::RESEARCH_SLUG => "string"])]
    public static function getEnums(): array
    {
        return [
            self::SERVICE_SLUG => self::SERVICE,
            self::RESEARCH_SLUG => self::RESEARCH,
        ];
    }
}
