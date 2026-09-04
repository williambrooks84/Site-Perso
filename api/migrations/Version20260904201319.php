<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260904201319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project ADD category_id INT DEFAULT NULL');
        $this->addSql("INSERT INTO category (name) VALUES ('Autre')");
        $this->addSql("UPDATE project SET category_id = (SELECT id FROM category WHERE name = 'Autre')");
        $this->addSql('ALTER TABLE project MODIFY category_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE12469DE2 ON project (category_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE12469DE2');
        $this->addSql('DROP INDEX IDX_2FB3D0EE12469DE2 ON project');
        $this->addSql('ALTER TABLE project DROP category_id');
        $this->addSql('DROP TABLE category');
    }
}