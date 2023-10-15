<?php

namespace App\PatientUser\Model\Api\Response;

class PatientAppointmentsCountModel
{
    public function __construct(
        private int $past,
        private int $upcoming,
    ) {}
}
