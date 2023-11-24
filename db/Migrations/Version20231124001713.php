<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124001713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Vytvoření tabulky kol';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        CREATE TABLE `bike` (
          `id` BINARY(16) NOT NULL,
          `location` VARCHAR(255) NOT NULL,
          `stand_id` BINARY(16) NULL,
          `last_service_timestamp` DATETIME NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
          INDEX `fk_bike_stand_idx` (`stand_id` ASC) VISIBLE,
          CONSTRAINT `fk_bike_stand`
            FOREIGN KEY (`stand_id`)
            REFERENCES `PIA-SP`.`stand` (`id`)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT);
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
