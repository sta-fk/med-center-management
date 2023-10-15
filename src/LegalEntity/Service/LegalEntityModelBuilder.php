<?php declare(strict_types=1);

namespace App\LegalEntity\Service;

use App\LegalEntity\Entity\LegalEntity;
use App\LegalEntity\Model\Api\LegalEntityModel;

class LegalEntityModelBuilder
{
    public function buildLegalEntityModel(LegalEntity $legalEntity): LegalEntityModel
    {
        return new LegalEntityModel(
            $legalEntity->getName(),
            $legalEntity->getEdrpou(),
            $legalEntity->getStatus(),
        );
    }
}
