<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250313170115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD breed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal DROP species');
        $this->addSql('ALTER TABLE animal DROP breed');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES animal_species (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA8B4A30F FOREIGN KEY (breed_id) REFERENCES animal_breed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FA8B4A30F ON animal (breed_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animal DROP CONSTRAINT FK_6AAB231FB2A1D860');
        $this->addSql('ALTER TABLE animal DROP CONSTRAINT FK_6AAB231FA8B4A30F');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860');
        $this->addSql('DROP INDEX IDX_6AAB231FA8B4A30F');
        $this->addSql('ALTER TABLE animal ADD species VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD breed VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE animal DROP species_id');
        $this->addSql('ALTER TABLE animal DROP breed_id');
    }
}
