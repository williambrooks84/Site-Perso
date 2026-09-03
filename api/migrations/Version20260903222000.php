<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260903222000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Replace Base64 project images with stored image paths';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project ADD image_path VARCHAR(500) DEFAULT NULL, DROP image_base64');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project ADD image_base64 LONGTEXT DEFAULT NULL, DROP image_path');
    }
}