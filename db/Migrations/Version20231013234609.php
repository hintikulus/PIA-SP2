<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013234609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'UUID jako binary';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        ALTER TABLE `user` 
CHANGE COLUMN `id` `id` BINARY(16) NOT NULL ;
');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
