<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011190251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee_contacts (id INT AUTO_INCREMENT NOT NULL, employee_info_id INT NOT NULL, type VARCHAR(128) NOT NULL, phone_number VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', INDEX IDX_A37F44B4DDC797F7 (employee_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_contacts (id INT AUTO_INCREMENT NOT NULL, patient_profile_id INT NOT NULL, type VARCHAR(128) NOT NULL, phone_number VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', INDEX IDX_4C54DD67A3AB457 (patient_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee_contacts ADD CONSTRAINT FK_A37F44B4DDC797F7 FOREIGN KEY (employee_info_id) REFERENCES employee_info (id)');
        $this->addSql('ALTER TABLE patient_contacts ADD CONSTRAINT FK_4C54DD67A3AB457 FOREIGN KEY (patient_profile_id) REFERENCES patient_profile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_contacts DROP FOREIGN KEY FK_A37F44B4DDC797F7');
        $this->addSql('ALTER TABLE patient_contacts DROP FOREIGN KEY FK_4C54DD67A3AB457');
        $this->addSql('DROP TABLE employee_contacts');
        $this->addSql('DROP TABLE patient_contacts');
    }
}
