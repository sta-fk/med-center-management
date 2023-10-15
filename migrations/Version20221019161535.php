<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019161535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointments (id INT AUTO_INCREMENT NOT NULL, time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointments_employee (appointments_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_B3B4BD9623F542AE (appointments_id), INDEX IDX_B3B4BD968C03F15C (employee_id), PRIMARY KEY(appointments_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointments_patient_profile (appointments_id INT NOT NULL, patient_profile_id INT NOT NULL, INDEX IDX_CCFAD0FF23F542AE (appointments_id), INDEX IDX_CCFAD0FF7A3AB457 (patient_profile_id), PRIMARY KEY(appointments_id, patient_profile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointments_service (appointments_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_C43481D023F542AE (appointments_id), INDEX IDX_C43481D0ED5CA9E6 (service_id), PRIMARY KEY(appointments_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointments_employee ADD CONSTRAINT FK_B3B4BD9623F542AE FOREIGN KEY (appointments_id) REFERENCES appointments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointments_employee ADD CONSTRAINT FK_B3B4BD968C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointments_patient_profile ADD CONSTRAINT FK_CCFAD0FF23F542AE FOREIGN KEY (appointments_id) REFERENCES appointments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointments_patient_profile ADD CONSTRAINT FK_CCFAD0FF7A3AB457 FOREIGN KEY (patient_profile_id) REFERENCES patient_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointments_service ADD CONSTRAINT FK_C43481D023F542AE FOREIGN KEY (appointments_id) REFERENCES appointments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointments_service ADD CONSTRAINT FK_C43481D0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_ehealth_info RENAME INDEX uniq_66996b67ccfa12b8 TO UNIQ_90FCD54DCCFA12B8');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointments_employee DROP FOREIGN KEY FK_B3B4BD9623F542AE');
        $this->addSql('ALTER TABLE appointments_employee DROP FOREIGN KEY FK_B3B4BD968C03F15C');
        $this->addSql('ALTER TABLE appointments_patient_profile DROP FOREIGN KEY FK_CCFAD0FF23F542AE');
        $this->addSql('ALTER TABLE appointments_patient_profile DROP FOREIGN KEY FK_CCFAD0FF7A3AB457');
        $this->addSql('ALTER TABLE appointments_service DROP FOREIGN KEY FK_C43481D023F542AE');
        $this->addSql('ALTER TABLE appointments_service DROP FOREIGN KEY FK_C43481D0ED5CA9E6');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('DROP TABLE appointments_employee');
        $this->addSql('DROP TABLE appointments_patient_profile');
        $this->addSql('DROP TABLE appointments_service');
        $this->addSql('ALTER TABLE patient_ehealth_info RENAME INDEX uniq_90fcd54dccfa12b8 TO UNIQ_66996B67CCFA12B8');
    }
}
