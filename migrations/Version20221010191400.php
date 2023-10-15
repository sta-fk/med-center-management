<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010191400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_additional_info (id INT AUTO_INCREMENT NOT NULL, patient_profile_id INT NOT NULL, inn VARCHAR(10) NOT NULL, document_type SMALLINT DEFAULT 1 NOT NULL, passport_series VARCHAR(2) DEFAULT NULL, passport_number VARCHAR(7) DEFAULT NULL, passport_give DATE DEFAULT NULL, passport_date DATE DEFAULT NULL, id_card_number VARCHAR(9) DEFAULT NULL, id_card_issued_by VARCHAR(255) DEFAULT NULL, id_card_issued_at DATE DEFAULT NULL, id_card_expired_at DATE DEFAULT NULL, gender TINYINT(1) NOT NULL, birth_date DATE NOT NULL, birth_country VARCHAR(255) DEFAULT NULL, birth_city VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4A93E307A3AB457 (patient_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_address (id INT AUTO_INCREMENT NOT NULL, patient_profile_id INT NOT NULL, country VARCHAR(128) NOT NULL, area VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, settlement_type VARCHAR(255) NOT NULL, settlement VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, house VARCHAR(255) DEFAULT NULL, apartment VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_502D3A6A7A3AB457 (patient_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_contacts (id INT AUTO_INCREMENT NOT NULL, patient_profile_id INT NOT NULL, type VARCHAR(128) NOT NULL, phone_number VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', INDEX IDX_4C54DD67A3AB457 (patient_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DC34FFE4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_additional_info ADD CONSTRAINT FK_4A93E307A3AB457 FOREIGN KEY (patient_profile_id) REFERENCES patient_profile (id)');
        $this->addSql('ALTER TABLE patient_address ADD CONSTRAINT FK_502D3A6A7A3AB457 FOREIGN KEY (patient_profile_id) REFERENCES patient_profile (id)');
        $this->addSql('ALTER TABLE patient_contacts ADD CONSTRAINT FK_4C54DD67A3AB457 FOREIGN KEY (patient_profile_id) REFERENCES patient_profile (id)');
        $this->addSql('ALTER TABLE patient_profile ADD CONSTRAINT FK_DC34FFE4A76ED395 FOREIGN KEY (user_id) REFERENCES patient_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_additional_info DROP FOREIGN KEY FK_4A93E307A3AB457');
        $this->addSql('ALTER TABLE patient_address DROP FOREIGN KEY FK_502D3A6A7A3AB457');
        $this->addSql('ALTER TABLE patient_contacts DROP FOREIGN KEY FK_4C54DD67A3AB457');
        $this->addSql('ALTER TABLE patient_profile DROP FOREIGN KEY FK_DC34FFE4A76ED395');
        $this->addSql('DROP TABLE patient_additional_info');
        $this->addSql('DROP TABLE patient_address');
        $this->addSql('DROP TABLE patient_contacts');
        $this->addSql('DROP TABLE patient_profile');
    }
}
