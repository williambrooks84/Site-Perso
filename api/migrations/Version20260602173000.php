<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260602173000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add base64 image storage to project table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project ADD image_base64 LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project DROP COLUMN image_base64');
    }
}