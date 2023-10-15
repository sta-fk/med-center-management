<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017183147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_ehealth (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, patient_id VARCHAR(255) NOT NULL, declaration_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_66996B67CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_ehealth ADD CONSTRAINT FK_66996B67CCFA12B8 FOREIGN KEY (profile_id) REFERENCES patient_profile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_ehealth DROP FOREIGN KEY FK_66996B67CCFA12B8');
        $this->addSql('DROP TABLE patient_ehealth');
    }
}
