<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115165042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates slug on table course';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE course ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE course DROP slug');
    }
}
