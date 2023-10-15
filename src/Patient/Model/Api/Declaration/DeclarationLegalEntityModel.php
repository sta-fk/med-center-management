<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Declaration;

use App\Base\Model\Api\ContactsModel;
use App\Base\Model\Api\FullAddressModel;
use JMS\Serializer\Annotation as JMS;

class DeclarationLegalEntityModel
{
    public function __construct(
        private string $id,
        private string $name,
        private string $edrpou,
        private string $status,
        private string $email,

        /**
         * @var ContactsModel[]
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array $phones,

        /**
         * @var FullAddressModel[]
         * @JMS\Type("array<App\Base\Model\Api\FullAddressModel>")
         */
        private array $addresses,
    ) {}
}
