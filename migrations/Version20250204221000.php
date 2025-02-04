<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204221000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animals_photos (id SERIAL NOT NULL, animal_id INT NOT NULL, filename VARCHAR(255) NOT NULL, width SMALLINT NOT NULL, height SMALLINT NOT NULL, size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D0431F798E962C16 ON animals_photos (animal_id)');
        $this->addSql('ALTER TABLE animals_photos ADD CONSTRAINT FK_D0431F798E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animals_photos DROP CONSTRAINT FK_D0431F798E962C16');
        $this->addSql('DROP TABLE animals_photos');
    }
}
