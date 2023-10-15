<?php declare(strict_types=1);

namespace App\Authorization\Service;

class CodeGenerator
{
    const RANDOM_STRING = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function getConfirmationCode(): string
    {
        $stringLength = strlen(self::RANDOM_STRING);
        $code = '';

        for ($i = 0; $i < $stringLength; $i++) {
            $code .= self::RANDOM_STRING[rand(0, $stringLength - 1)];
        }

        return $code;
    }
}
