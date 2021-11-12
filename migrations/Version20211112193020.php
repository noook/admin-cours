<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112193020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates Course and Exercises tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN course.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE course_group (course_id UUID NOT NULL, group_id UUID NOT NULL, PRIMARY KEY(course_id, group_id))');
        $this->addSql('CREATE INDEX IDX_846B432D591CC992 ON course_group (course_id)');
        $this->addSql('CREATE INDEX IDX_846B432DFE54D947 ON course_group (group_id)');
        $this->addSql('COMMENT ON COLUMN course_group.course_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN course_group.group_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE exercise (id UUID NOT NULL, course_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AEDAD51C591CC992 ON exercise (course_id)');
        $this->addSql('COMMENT ON COLUMN exercise.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN exercise.course_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE course_group ADD CONSTRAINT FK_846B432D591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_group ADD CONSTRAINT FK_846B432DFE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_group DROP CONSTRAINT FK_846B432D591CC992');
        $this->addSql('ALTER TABLE exercise DROP CONSTRAINT FK_AEDAD51C591CC992');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_group');
        $this->addSql('DROP TABLE exercise');
    }
}
