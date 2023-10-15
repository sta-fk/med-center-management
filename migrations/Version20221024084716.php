<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024084716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_appointment_result (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, service_id INT NOT NULL, appointment_id INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', result JSON NOT NULL, INDEX IDX_A4D04CC46B899279 (patient_id), INDEX IDX_A4D04CC4ED5CA9E6 (service_id), UNIQUE INDEX UNIQ_A4D04CC4E5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_result (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, template JSON NOT NULL, INDEX IDX_2DADC425ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_appointment_result ADD CONSTRAINT FK_A4D04CC46B899279 FOREIGN KEY (patient_id) REFERENCES patient_profile (id)');
        $this->addSql('ALTER TABLE patient_appointment_result ADD CONSTRAINT FK_A4D04CC4ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE patient_appointment_result ADD CONSTRAINT FK_A4D04CC4E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointments (id)');
        $this->addSql('ALTER TABLE service_result ADD CONSTRAINT FK_2DADC425ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_appointment_result DROP FOREIGN KEY FK_A4D04CC46B899279');
        $this->addSql('ALTER TABLE patient_appointment_result DROP FOREIGN KEY FK_A4D04CC4ED5CA9E6');
        $this->addSql('ALTER TABLE patient_appointment_result DROP FOREIGN KEY FK_A4D04CC4E5B533F9');
        $this->addSql('ALTER TABLE service_result DROP FOREIGN KEY FK_2DADC425ED5CA9E6');
        $this->addSql('DROP TABLE patient_appointment_result');
        $this->addSql('DROP TABLE service_result');
    }
}
