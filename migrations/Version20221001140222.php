<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001140222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE division (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, dls_verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, division_id INT DEFAULT NULL, legal_entity_id INT NOT NULL, employee_type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, brief VARCHAR(255) NOT NULL, INDEX IDX_5D9F75A141859289 (division_id), INDEX IDX_5D9F75A16DEC420C (legal_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_contacts (id INT AUTO_INCREMENT NOT NULL, employee_info_id INT NOT NULL, type VARCHAR(128) NOT NULL, phone_number VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', INDEX IDX_A37F44B4DDC797F7 (employee_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_education (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, country VARCHAR(10) NOT NULL, city VARCHAR(255) NOT NULL, institution_name VARCHAR(255) NOT NULL, issued_date DATETIME NOT NULL, degree VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, INDEX IDX_DE9A36908C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_info (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, gender TINYINT(1) NOT NULL, inn VARCHAR(10) NOT NULL, working_experience SMALLINT NOT NULL, about_myself VARCHAR(255) NOT NULL, declaration_limit SMALLINT NOT NULL, declaration_count SMALLINT NOT NULL, UNIQUE INDEX UNIQ_7E507B108C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_qualification (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, type VARCHAR(255) NOT NULL, institution_name VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, issued_date DATE NOT NULL, valid_to DATE NOT NULL, additional_info VARCHAR(255) NOT NULL, INDEX IDX_C1E084758C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_speciality (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, speciality VARCHAR(255) NOT NULL, speciality_officio TINYINT(1) NOT NULL, level SMALLINT NOT NULL, qualification_type VARCHAR(255) NOT NULL, attestation_name VARCHAR(255) NOT NULL, attestation_date DATE NOT NULL, valid_to DATE NOT NULL, INDEX IDX_6B00105A8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legal_entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, edrpou VARCHAR(10) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A141859289 FOREIGN KEY (division_id) REFERENCES division (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A16DEC420C FOREIGN KEY (legal_entity_id) REFERENCES legal_entity (id)');
        $this->addSql('ALTER TABLE employee_contacts ADD CONSTRAINT FK_A37F44B4DDC797F7 FOREIGN KEY (employee_info_id) REFERENCES employee_info (id)');
        $this->addSql('ALTER TABLE employee_education ADD CONSTRAINT FK_DE9A36908C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee_info ADD CONSTRAINT FK_7E507B108C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee_qualification ADD CONSTRAINT FK_C1E084758C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee_speciality ADD CONSTRAINT FK_6B00105A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A141859289');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A16DEC420C');
        $this->addSql('ALTER TABLE employee_contacts DROP FOREIGN KEY FK_A37F44B4DDC797F7');
        $this->addSql('ALTER TABLE employee_education DROP FOREIGN KEY FK_DE9A36908C03F15C');
        $this->addSql('ALTER TABLE employee_info DROP FOREIGN KEY FK_7E507B108C03F15C');
        $this->addSql('ALTER TABLE employee_qualification DROP FOREIGN KEY FK_C1E084758C03F15C');
        $this->addSql('ALTER TABLE employee_speciality DROP FOREIGN KEY FK_6B00105A8C03F15C');
        $this->addSql('DROP TABLE division');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_contacts');
        $this->addSql('DROP TABLE employee_education');
        $this->addSql('DROP TABLE employee_info');
        $this->addSql('DROP TABLE employee_qualification');
        $this->addSql('DROP TABLE employee_speciality');
        $this->addSql('DROP TABLE legal_entity');
    }
}
