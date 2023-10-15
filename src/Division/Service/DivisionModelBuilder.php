<?php declare(strict_types=1);

namespace App\Division\Service;

use App\Division\Entity\Division;
use App\Division\Model\Api\DivisionModel;

class DivisionModelBuilder
{
    public function buildDivisionModel(Division $division): DivisionModel
    {
        return new DivisionModel(
            $division->getName(),
        );
    }
}
