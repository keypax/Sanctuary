<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304204032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_6aab231fd04fe1e5');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231FD04FE1E5 ON animal (enclosure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_6AAB231FD04FE1E5');
        $this->addSql('CREATE INDEX idx_6aab231fd04fe1e5 ON animal (enclosure_id)');
    }
}
