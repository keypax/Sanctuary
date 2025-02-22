<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222191902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_photo ADD filename_big VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE animal_photo ADD filename_medium VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE animal_photo ADD filename_small VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE animal_photo RENAME COLUMN filename TO filename_original');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animal_photo ADD filename VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE animal_photo DROP filename_original');
        $this->addSql('ALTER TABLE animal_photo DROP filename_big');
        $this->addSql('ALTER TABLE animal_photo DROP filename_medium');
        $this->addSql('ALTER TABLE animal_photo DROP filename_small');
    }
}
