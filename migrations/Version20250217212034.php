<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217212034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_breed DROP CONSTRAINT fk_d95c51bb4a93e3a9');
        $this->addSql('DROP SEQUENCE animal_type_id_seq CASCADE');
        $this->addSql('CREATE TABLE animal_species (id SERIAL NOT NULL, species_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE animal_type');
        $this->addSql('DROP INDEX idx_d95c51bb4a93e3a9');
        $this->addSql('ALTER TABLE animal_breed RENAME COLUMN animal_type_id TO animal_species_id');
        $this->addSql('ALTER TABLE animal_breed ADD CONSTRAINT FK_D95C51BB6F540084 FOREIGN KEY (animal_species_id) REFERENCES animal_species (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D95C51BB6F540084 ON animal_breed (animal_species_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animal_breed DROP CONSTRAINT FK_D95C51BB6F540084');
        $this->addSql('CREATE SEQUENCE animal_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE animal_type (id SERIAL NOT NULL, type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE animal_species');
        $this->addSql('DROP INDEX IDX_D95C51BB6F540084');
        $this->addSql('ALTER TABLE animal_breed RENAME COLUMN animal_species_id TO animal_type_id');
        $this->addSql('ALTER TABLE animal_breed ADD CONSTRAINT fk_d95c51bb4a93e3a9 FOREIGN KEY (animal_type_id) REFERENCES animal_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d95c51bb4a93e3a9 ON animal_breed (animal_type_id)');
    }
}
