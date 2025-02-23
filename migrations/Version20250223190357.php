<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223190357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_history (id SERIAL NOT NULL, animal_id INT NOT NULL, before VARCHAR(255) DEFAULT NULL, after VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A8651F718E962C16 ON animal_history (animal_id)');
        $this->addSql('ALTER TABLE animal_history ADD CONSTRAINT FK_A8651F718E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animal_history DROP CONSTRAINT FK_A8651F718E962C16');
        $this->addSql('DROP TABLE animal_history');
    }
}
