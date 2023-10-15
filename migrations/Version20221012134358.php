<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012134358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee CHANGE start_date start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE end_date end_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE employee_education CHANGE issued_date issued_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE employee_info CHANGE birth_date birth_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE employee_qualification CHANGE issued_date issued_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE valid_to valid_to DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE employee_speciality CHANGE attestation_date attestation_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE valid_to valid_to DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE patient_additional_info CHANGE passport_date passport_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE id_card_issued_at id_card_issued_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE id_card_expired_at id_card_expired_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE birth_date birth_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee CHANGE start_date start_date DATE NOT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE employee_education CHANGE issued_date issued_date DATE NOT NULL');
        $this->addSql('ALTER TABLE employee_info CHANGE birth_date birth_date DATE NOT NULL');
        $this->addSql('ALTER TABLE employee_qualification CHANGE issued_date issued_date DATE NOT NULL, CHANGE valid_to valid_to DATE NOT NULL');
        $this->addSql('ALTER TABLE employee_speciality CHANGE attestation_date attestation_date DATE NOT NULL, CHANGE valid_to valid_to DATE NOT NULL');
        $this->addSql('ALTER TABLE patient_additional_info CHANGE passport_date passport_date DATE DEFAULT NULL, CHANGE id_card_issued_at id_card_issued_at DATE DEFAULT NULL, CHANGE id_card_expired_at id_card_expired_at DATE DEFAULT NULL, CHANGE birth_date birth_date DATE NOT NULL');
    }
}
