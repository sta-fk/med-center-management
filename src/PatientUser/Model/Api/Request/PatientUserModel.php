<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Request;

use App\Api\Request\ModelArgumentValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PatientUserModel implements ModelArgumentValueInterface
{
    public function __construct(
        /**
         * @Assert\NotBlank()
         * @Assert\Regex("/^[a-z\d._-]+@[a-z\d._-]+\.[a-z]{2,6}$/", message="api.email.email_invalid")
         */
        private string $email,

        /**
         * @Assert\NotBlank()
         * @Assert\Regex(
         *     "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/",
         *     message="api.password.password_invalid"
         * )
         */
        private string $plainPassword,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
