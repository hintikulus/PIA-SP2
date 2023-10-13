<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013220959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql("
        CREATE
    FUNCTION BIN_TO_UUID(bin_uuid BINARY(16), swap_flag BOOLEAN)
    RETURNS CHAR(36)
    DETERMINISTIC
    BEGIN
       DECLARE hex_uuid CHAR(32);
       SET hex_uuid = HEX(bin_uuid);
       RETURN LOWER(CONCAT(
            IF(swap_flag, SUBSTR(hex_uuid, 9, 8),SUBSTR(hex_uuid, 1, 8)), '-',
            IF(swap_flag, SUBSTR(hex_uuid, 5, 4),SUBSTR(hex_uuid, 9, 4)), '-',
            IF(swap_flag, SUBSTR(hex_uuid, 1, 4),SUBSTR(hex_uuid, 13, 4)), '-',
            SUBSTR(hex_uuid, 17, 4), '-',
            SUBSTR(hex_uuid, 21)
        ));
    END
        ");

        $this->addSql("
        CREATE
    FUNCTION UUID_TO_BIN(str_uuid CHAR(36), swap_flag BOOLEAN)
    RETURNS BINARY(16)
    DETERMINISTIC
    BEGIN
      RETURN UNHEX(CONCAT(
          IF(swap_flag, SUBSTR(str_uuid, 15, 4),SUBSTR(str_uuid, 1, 8)),
          SUBSTR(str_uuid, 10, 4),
          IF(swap_flag, SUBSTR(str_uuid, 1, 8),SUBSTR(str_uuid, 15, 4)),
          SUBSTR(str_uuid, 20, 4),
          SUBSTR(str_uuid, 25))
      );
    END
");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
