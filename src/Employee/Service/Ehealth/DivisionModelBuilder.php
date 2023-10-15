<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\DivisionModel;

class DivisionModelBuilder
{
    public function buildDivisionModel(array $division): DivisionModel
    {
        return new DivisionModel(
            $division['id'],
            $division['name'],
            $division['type'],
            $division['status'],
            $division['dls_verified'],
        );
    }
}
