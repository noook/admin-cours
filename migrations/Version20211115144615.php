<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115144615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds slug column to exercise';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE exercise ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE exercise ALTER content DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE exercise DROP slug');
        $this->addSql('ALTER TABLE exercise ALTER content SET DEFAULT \'\'');
    }
}
