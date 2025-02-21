<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * (semi) auto-generated Migration: Please modify to your needs!
 */
final class Version20250221110451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        //custom migration
        $this->addSql('ALTER TABLE animals_photos DROP CONSTRAINT fk_d0431f798e962c16');
        $this->addSql('DROP TABLE animals_photos CASCADE');
        $this->addSql('DROP TABLE animals CASCADE');

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE IF EXISTS animals_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE IF EXISTS animals_photos_id_seq CASCADE');
        $this->addSql('CREATE TABLE animal (id SERIAL NOT NULL, animal_id VARCHAR(255) NOT NULL, animal_name VARCHAR(255) DEFAULT NULL, species VARCHAR(50) NOT NULL, breed VARCHAR(100) DEFAULT NULL, gender SMALLINT DEFAULT 0 NOT NULL, birth_date DATE DEFAULT NULL, approximate_age SMALLINT DEFAULT NULL, description TEXT DEFAULT NULL, color VARCHAR(100) DEFAULT NULL, distinctive_marks VARCHAR(255) DEFAULT NULL, size SMALLINT DEFAULT NULL, admission_date DATE NOT NULL, adoption_status SMALLINT DEFAULT NULL, adoption_date DATE DEFAULT NULL, chip_number VARCHAR(30) DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unique_animal_id ON animal (animal_id)');
        $this->addSql('CREATE TABLE animal_photo (id SERIAL NOT NULL, animal_id INT NOT NULL, filename VARCHAR(255) NOT NULL, width SMALLINT NOT NULL, height SMALLINT NOT NULL, size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_35445DEC8E962C16 ON animal_photo (animal_id)');
        $this->addSql('ALTER TABLE animal_photo ADD CONSTRAINT FK_35445DEC8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE animal CASCADE');
        $this->addSql('DROP TABLE animal_photo CASCADE');

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE animals_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE animals_photos_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE animals (id SERIAL NOT NULL, animal_id VARCHAR(255) NOT NULL, animal_name VARCHAR(255) DEFAULT NULL, species VARCHAR(50) NOT NULL, breed VARCHAR(100) DEFAULT NULL, gender SMALLINT DEFAULT 0 NOT NULL, birth_date DATE DEFAULT NULL, approximate_age SMALLINT DEFAULT NULL, description TEXT DEFAULT NULL, color VARCHAR(100) DEFAULT NULL, distinctive_marks VARCHAR(255) DEFAULT NULL, size SMALLINT DEFAULT NULL, admission_date DATE NOT NULL, adoption_status SMALLINT DEFAULT NULL, adoption_date DATE DEFAULT NULL, chip_number VARCHAR(30) DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unique_animal_id ON animals (animal_id)');
        $this->addSql('CREATE TABLE animals_photos (id SERIAL NOT NULL, animal_id INT NOT NULL, filename VARCHAR(255) NOT NULL, width SMALLINT NOT NULL, height SMALLINT NOT NULL, size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d0431f798e962c16 ON animals_photos (animal_id)');
        $this->addSql('ALTER TABLE animals_photos ADD CONSTRAINT fk_d0431f798e962c16 FOREIGN KEY (animal_id) REFERENCES animals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE animal_photo DROP CONSTRAINT FK_35445DEC8E962C16');
    }
}
