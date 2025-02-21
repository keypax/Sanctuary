<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221152338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX unique_animal_id');
        $this->addSql('ALTER TABLE animal RENAME COLUMN animal_id TO animal_internal_id');
        $this->addSql('CREATE UNIQUE INDEX unique_animal_internal_id ON animal (animal_internal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX unique_animal_internal_id');
        $this->addSql('ALTER TABLE animal RENAME COLUMN animal_internal_id TO animal_id');
        $this->addSql('CREATE UNIQUE INDEX unique_animal_id ON animal (animal_id)');
    }
}
