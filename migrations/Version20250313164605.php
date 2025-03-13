<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250313164605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ALTER species DROP NOT NULL');
        $this->addSql('ALTER TABLE animal ALTER species TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE animal ALTER breed TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE animal ALTER species SET NOT NULL');
        $this->addSql('ALTER TABLE animal ALTER species TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE animal ALTER breed TYPE VARCHAR(100)');
    }
}
