<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305223846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_6aab231fd04fe1e5');
        $this->addSql('ALTER TABLE animal ADD updated_at DATE DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_6AAB231FD04FE1E5 ON animal (enclosure_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_enclosure_name ON enclosure (enclosure_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX unique_enclosure_name');
        $this->addSql('DROP INDEX IDX_6AAB231FD04FE1E5');
        $this->addSql('ALTER TABLE animal DROP updated_at');
        $this->addSql('CREATE UNIQUE INDEX uniq_6aab231fd04fe1e5 ON animal (enclosure_id)');
    }
}
