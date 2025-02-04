<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201203320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animals (id SERIAL NOT NULL, animal_id VARCHAR(255) NOT NULL, animal_name VARCHAR(255) DEFAULT NULL, species VARCHAR(50) NOT NULL, breed VARCHAR(100) DEFAULT NULL, gender SMALLINT DEFAULT NULL, birth_date DATE DEFAULT NULL, approximate_age VARCHAR(50) DEFAULT NULL, description TEXT DEFAULT NULL, color VARCHAR(100) DEFAULT NULL, distinctive_marks VARCHAR(255) DEFAULT NULL, size SMALLINT DEFAULT NULL, admission_date DATE NOT NULL, adoption_status SMALLINT DEFAULT NULL, adoption_date DATE DEFAULT NULL, chip_number VARCHAR(30) DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE animals');
    }
}
