<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260903120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove the unused illustration field from projects';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project DROP illustration');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project ADD illustration VARCHAR(255) DEFAULT NULL');
    }
}