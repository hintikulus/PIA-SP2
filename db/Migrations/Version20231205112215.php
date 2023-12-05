<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205112215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Vytvoření tabulky s jízdami';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            "CREATE TABLE `PIA-SP`.`ride` (
  `id` BINARY(16) NOT NULL,
  `user_id` BINARY(16) NOT NULL,
  `bike_id` BINARY(16) NOT NULL,
  `state` INT NOT NULL,
  `start_timestamp` DATETIME NOT NULL,
  `start_stand_id` BINARY(16) NOT NULL,
  `end_timestamp` DATETIME NULL,
  `end_stand_id` BINARY(16) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_ride_user_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_ride_start_stand_idx` (`start_stand_id` ASC) VISIBLE,
  INDEX `fk_ride_end_stand_idx` (`end_stand_id` ASC) VISIBLE,
  INDEX `fk_ride_bike_idx` (`bike_id` ASC) VISIBLE,
  CONSTRAINT `fk_ride_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `PIA-SP`.`user` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_ride_start_stand`
    FOREIGN KEY (`start_stand_id`)
    REFERENCES `PIA-SP`.`stand` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_ride_end_stand`
    FOREIGN KEY (`end_stand_id`)
    REFERENCES `PIA-SP`.`stand` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_ride_bike`
    FOREIGN KEY (`bike_id`)
    REFERENCES `PIA-SP`.`bike` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);
"
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
