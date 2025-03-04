<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304200158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enclosure (id SERIAL NOT NULL, enclosure_name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE animal ADD enclosure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6AAB231FD04FE1E5 ON animal (enclosure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animal DROP CONSTRAINT FK_6AAB231FD04FE1E5');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP INDEX IDX_6AAB231FD04FE1E5');
        $this->addSql('ALTER TABLE animal DROP enclosure_id');
    }
}
