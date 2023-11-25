<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125030540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Propojení s google';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        ALTER TABLE `user` 
ADD COLUMN `google_id` VARCHAR(45) NULL AFTER `last_login`,
ADD UNIQUE INDEX `google_id_UNIQUE` (`google_id` ASC);
;
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
