<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\LegalEntityModel;

class LegalEntityModelBuilder
{
    public function buildLegalEntityModel(array $legalEntity): LegalEntityModel
    {
        return new LegalEntityModel(
            $legalEntity['id'],
            $legalEntity['public_name'],
            $legalEntity['edrpou'],
            $legalEntity['status'],
        );
    }
}
